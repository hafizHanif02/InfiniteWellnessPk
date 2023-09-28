<?php

namespace App\Http\Controllers;

use App\Exports\TransferExport;
use App\Http\Requests\NewstockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ItemStock;
use App\Models\Medicine;
use App\Models\Shift\Transfer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Inventory\Product;

class NewStockController extends Controller
{
    public function index()
    {
        // return Transfer::with('transferProducts')->where('status', null)->latest()->paginate(10)->onEachSide(1);
        return view('new-stocks.index', [
            'newStocks' => Transfer::where('status', null)->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function updateStatus(NewstockRequest $request, Transfer $transfer): RedirectResponse
    {


        if ($request->status == 1) {
            $transfer = $transfer->load(['transferProducts.product.productCategory','transferProducts.product.dosage','transferProducts.product.manufacturer' ,'transferProducts.product.vendor','transferProducts.product.generic']);
            foreach ($transfer->transferProducts as $transferProduct) {
                // dd($transferProduct);
                $itemCategory = ItemCategory::firstOrCreate([
                    'name' => $transferProduct->product->productCategory->name,
                ]);

                $itemName = $transferProduct->product->product_name;
                $item = Item::where('name', $itemName)->first();

                if ($item) {
                    $item->increment('available_quantity', $transferProduct->total_piece);
                } else {
                    $item = Item::create([
                        'name' => $itemName,
                        'itemcategory_id' => $itemCategory->id,
                        'unit' => $transferProduct->product->unit_of_measurement,
                        'description' => $transferProduct->product->package_detail,
                        'available_quantity' => $transferProduct->total_piece,
                    ]);
                }

                $itemIdExists = ItemStock::where('item_id', $item->id)->exists();

                if ($itemIdExists) {
                    ItemStock::where('item_id', $item->id)->incrementEach([
                        'quantity' => $transferProduct->total_piece,
                    ])->update([
                        'purchase_price' => $transferProduct->price_per_unit,
                    ]);
                } else {
                    ItemStock::create([
                        'itemcategory_id' => $itemCategory->id,
                        'item_id' => $item->id,
                        // 'supplier_name' => $transferProduct->product->vendor->account_title,
                        'store_name' => 'Test store',
                        'quantity' => $transferProduct->total_piece,
                        'purchase_price' => $transferProduct->price_per_unit,
                        'description' => $transferProduct->product->package_detail,
                        'currency_symbol' => 'Rs',
                    ]);

                    $category = Category::create([
                        'name' => $transferProduct->product->productCategory->name,
                        'is_active' => 1,
                    ]);

                    $brand = Brand::create([
                        'name' => $transferProduct->product->manufacturer->company_name,
                    ]);
                }

                $medicineNameExists = Medicine::where('name', $transferProduct->product->product_name)->exists();

                // dd($transferProduct->total_piece);
                if ($medicineNameExists) {
                    Medicine::where('name', $transferProduct->product->product_name)->incrementEach([
                        'total_quantity' => $transferProduct->total_piece,
                    ])->update([
                        'selling_price' => $transferProduct->product->unit_trade,
                        'buying_price' => $transferProduct->product->cost_price,
                    ]);
                } else {
                    $brands = Brand::where('name',$transferProduct->product->manufacturer->company_name)->first();
                    if($brands){
                        Medicine::create([
                            'dosage_form' => $transferProduct->product->dosage->name,
                            'category_id' => $transferProduct->product->product_category_id,
                            'brand_id' => $brands->id,
                            'name' => $transferProduct->product->product_name,
                            'generic_formula' => $transferProduct->product->generic->formula,
                            'barcode' => $transferProduct->product->barcode,
                            'selling_price' => $transferProduct->product->unit_trade,
                            'buying_price' => $transferProduct->product->cost_price,
                            'description' => $transferProduct->product->package_detail,
                            'salt_composition' => $transferProduct->product->generic->formula,
                            'total_quantity' => $transferProduct->total_piece,
                            'currency_symbol' => 'Rs',
                        ]);
                    }
                    else{
                        $brands =  Brand::create([
                            'name' => $transferProduct->product->manufacturer->company_name
                        ]);
                        Medicine::create([
                            'dosage_form' => $transferProduct->product->dosage->name,
                            'category_id' => $transferProduct->product->product_category_id,
                            'brand_id' => $brands->id,
                            'name' => $transferProduct->product->product_name,
                            'generic_formula' => $transferProduct->product->generic->formula,
                            'barcode' => $transferProduct->product->barcode,
                            'selling_price' => $transferProduct->product->unit_trade,
                            'buying_price' => $transferProduct->product->cost_price,
                            'description' => $transferProduct->product->package_detail,
                            'salt_composition' => $transferProduct->product->generic->formula,
                            'total_quantity' => $transferProduct->total_piece,
                            'currency_symbol' => 'Rs',
                        ]);
                    }
                }
            }
        }
        $transfer->update([
            'status' => $request->status,
        ]);
        foreach ($transfer->transferProducts as $transferProduct){
            // dd($transferProduct);
            Product::where('id',$transferProduct->product_id)->incrementEach([
                'total_quantity' => $transferProduct->total_piece
            ]);
        }

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

    public function exportTransferReport()
    {
        $date = now();

        return (new TransferExport)->download('Transfer_Report'.$date.'.xlsx');
    }
}
