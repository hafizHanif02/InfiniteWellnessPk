<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Item;
use App\Models\Batch;
use App\Models\Brand;
use App\Models\BatchPOS;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\ItemStock;
use Illuminate\View\View;
use App\Models\ItemCategory;
use App\Models\Shift\Transfer;
use App\Exports\TransferExport;
use App\Models\Inventory\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Shift\TransferProduct;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\NewstockRequest;

class NewStockController extends Controller
{
    public function index()
    {
        // return Transfer::with('transferProducts')->where('status', null)->latest()->paginate(10)->onEachSide(1);
        return view('new-stocks.index', [
            'newStocks' => Transfer::where('status', null)->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function updateStatus(NewstockRequest $request, Transfer $transfer)
    {


        if ($request->status == 1) {

            $transfer = $transfer->load(['transferProducts.product.productCategory', 'transferProducts.product.dosage', 'transferProducts.product.manufacturer', 'transferProducts.product.vendor', 'transferProducts.product.generic']);


            $user = Auth::user();
            $requistionproductlogs = 'Transfer No:' . $transfer->id . ' Products:{[produc_id, qty],';
                
            foreach ($transfer->transferProducts as $transferProduct) {
                Product::where('id', $transferProduct->product_id)->decrement(
                    'total_quantity',
                    $transferProduct->total_piece
                );


                $itemCategory = ItemCategory::firstOrCreate([
                    'name' => $transferProduct->product->productCategory->name,
                ]);

                // $transfer_product = TransferProduct::where('transfer_id', $transferProduct->transfer_id)->first();


                if ($transferProduct->batch_id != null) {
                    $batch = Batch::where('id', $transferProduct->batch_id)->first();



                    if ($batch->quantity >= $transferProduct->total_piece) {
                        Batch::where('id', $transferProduct->batch_id)->update([
                            'transfer_quantity' => $batch->transfer_quantity + $transferProduct->total_piece,
                            'remaining_qty' => $batch->remaining_qty - $transferProduct->total_piece,
                        ]);
                        // dd($batch->remaining_qty);
                        $batchpos = BatchPOS::where('product_id', $transferProduct->product_id)->where('batch_id', $transferProduct->batch_id)->first();

                        if ($batchpos) {
                            if ($batchpos->batch_id == $batch->id) {
                                $batchpos->increment('quantity', $transferProduct->total_piece);
                                $batchpos->increment('remaining_qty', $transferProduct->total_piece);
                            } else {
                                BatchPOS::create([
                                    'batch_id' => $transferProduct->batch_id,
                                    'product_id' => $transferProduct->product_id,
                                    'unit_trade' => $transferProduct->unit_trade,
                                    'unit_retail' => $batch->unit_retail,
                                    'quantity' => $transferProduct->total_piece,
                                    'remaining_qty' => $transferProduct->total_piece,
                                    'expiry_date' => $batch->expiry_date,
                                    'sold_quantity' => 0,
                                ]);
                            }
                        } else {
                            BatchPOS::create([
                                'batch_id' => $transferProduct->batch_id,
                                'product_id' => $transferProduct->product_id,
                                'unit_trade' => $transferProduct->unit_trade,
                                'unit_retail' => $batch->unit_retail,
                                'quantity' => $transferProduct->total_piece,
                                'remaining_qty' => $transferProduct->total_piece,
                                'expiry_date' => $batch->expiry_date,
                                'sold_quantity' => 0,
                            ]);
                        }
                    } else {
                        return redirect()->back()->with('success', 'Insufficient Stock!');
                    }
                }



                $medicineNameExists = Medicine::where('name', $transferProduct->product->product_name)->exists();

                // dd($transferProduct->total_piece);
                if ($medicineNameExists) {
                    Medicine::where('name', $transferProduct->product->product_name)->incrementEach([
                        'total_quantity' => $transferProduct->total_piece,
                    ])->update([
                        'selling_price' => $transferProduct->product->unit_retail,
                        'buying_price' => $transferProduct->product->cost_price,
                        'barcode' => $transferProduct->product->barcode,
                    ]);
                } else {
                    $brands = Brand::where('name', $transferProduct->product->manufacturer->company_name)->first();
                    if ($brands) {
                        Medicine::create([
                            'dosage_form' => $transferProduct->product->dosage->name,
                            'product_id' => $transferProduct->product->id,
                            'category_id' => $transferProduct->product->product_category_id,
                            'brand_id' => $brands->id,
                            'name' => $transferProduct->product->product_name,
                            'generic_formula' => $transferProduct->product->generic->formula,
                            'barcode' => $transferProduct->product->barcode,
                            'selling_price' => $transferProduct->product->unit_retail,
                            'buying_price' => $transferProduct->product->cost_price,
                            'description' => $transferProduct->product->package_detail,
                            'salt_composition' => $transferProduct->product->generic->formula,
                            'total_quantity' => $transferProduct->total_piece,
                            'currency_symbol' => 'Rs',
                        ]);
                    } else {
                        $brands =  Brand::create([
                            'name' => $transferProduct->product->manufacturer->company_name
                        ]);
                        Medicine::create([
                            'dosage_form' => $transferProduct->product->dosage->name,
                            'product_id' => $transferProduct->product->id,
                            'category_id' => $transferProduct->product->product_category_id,
                            'brand_id' => $brands->id,
                            'name' => $transferProduct->product->product_name,
                            'generic_formula' => $transferProduct->product->generic->formula,
                            'barcode' => $transferProduct->product->barcode,
                            'selling_price' => $transferProduct->product->unit_retail,
                            'buying_price' => $transferProduct->product->cost_price,
                            'description' => $transferProduct->product->package_detail,
                            'salt_composition' => $transferProduct->product->generic->formula,
                            'total_quantity' => $transferProduct->total_piece,
                            'currency_symbol' => 'Rs',
                        ]);
                    }
                }
                $requistionproductlogs .= '[' . $transferProduct->product->id . ',' . $transferProduct->total_piece . '],';
            }
            $requistionproductlogs .= '}';
            $user = Auth::user();
            $logs = Log::create([
                'action' => 'Transfer Has Been ' . ($request->status == 1 ? 'Approved' : 'Rejected') . ' Transfer No.' . $transfer->id,
                'action_by_user_id' => $user->id,
            ]);
            $fileName = 'log/' . $logs->id . '.txt';
            $filePath = public_path($fileName);
            $directory = dirname($filePath);
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            file_put_contents($filePath, $requistionproductlogs);
        }
        $transfer->update([
            'status' => $request->status,
        ]);

        return back();
    }

    public function report(): View
    {
        return view('new-stocks.report', [
            'reportStocks' => Transfer::where('status', '!=', null)->with('transferProducts.product')->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function show(Transfer $transfer): View
    {
        return view('new-stocks.report-detail', [
            'stockReport' => $transfer->load(['transferProducts.product.dosage', 'transferProducts.product.generic', 'transferProducts.product.vendor', 'transferProducts.product.manufacturer', 'transferProducts.product.productCategory']),
        ]);
    }
    public function print(Transfer $transfer): View
    {
        return view('new-stocks.print', [
            'stockReport' => $transfer->load(['transferProducts.product.dosage', 'transferProducts.product.generic', 'transferProducts.product.vendor', 'transferProducts.product.manufacturer', 'transferProducts.product.productCategory']),
        ]);
    }

    public function exportTransferReport()
    {
        $date = now();

        return (new TransferExport)->download('Transfer_Report' . $date . '.xlsx');
    }
}
