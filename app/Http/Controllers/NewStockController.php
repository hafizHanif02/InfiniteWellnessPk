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

class NewStockController extends Controller
{
    public function index(): View
    {
        return view('new-stocks.index', [
            'newStocks' => Transfer::where('status', null)->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function updateStatus(NewstockRequest $request, Transfer $transfer): RedirectResponse
    {
        if ($request->status == 1) {
            $transfer = $transfer->load(['transferProducts.product.productCategory', 'transferProducts.product.vendor']);
            foreach ($transfer->transferProducts as $transferProduct) {

                $itemCategory = ItemCategory::firstOrCreate([
                    'name' => $transferProduct->product->productCategory->name,
                ]);

                $itemName = $transferProduct->product->product_name;
                $item = Item::where('name', $itemName)->first();

                if ($item) {
                    $item->increment('available_quantity', $transferProduct->supply_qty);
                } else {
                    $item = Item::create([
                        'name' => $itemName,
                        'item_category_id' => $itemCategory->id,
                        'unit' => $transferProduct->product->least_unit,
                        'description' => $transferProduct->product->package_detail,
                        'available_quantity' => $transferProduct->supply_qty,
                    ]);
                }

                $itemIdExists = ItemStock::where('item_id', $item->id)->exists();

                if ($itemIdExists) {
                    ItemStock::where('item_id', $item->id)->incrementEach([
                        'quantity' => $transferProduct->supply_qty,
                        'purchase_price' => $transferProduct->item_amount,
                    ]);
                } else {
                    ItemStock::create([
                        'item_category_id' => $itemCategory->id,
                        'item_id' => $item->id,
                        'supplier_name' => $transferProduct->product->vendor->account_title,
                        'store_name' => 'Test store',
                        'quantity' => $transferProduct->supply_qty,
                        'purchase_price' => $transferProduct->product->unit_retail,
                        'description' => $transferProduct->product->package_detail,
                        'currency_symbol' => 'Rs',
                    ]);

                    $category = Category::create([
                        'name' => $transferProduct->product->productCategory->name,
                        'is_active' => 1,
                    ]);

                    $brand = Brand::create([
                        'name' => $transferProduct->product->manufacturer->company_name,
                        'email' => $transferProduct->product->manufacturer->email,
                        'phone' => $transferProduct->product->manufacturer->phone,
                    ]);
                }

                $medicineNameExists = Medicine::where('name', $transferProduct->product->product_name)->exists();

                // dd($transferProduct->supply_qty);
                if ($medicineNameExists) {
                    Medicine::where('name', $transferProduct->product->product_name)->incrementEach([
                        'selling_price' => $transferProduct->product->trade_price,
                        'buying_price' => $transferProduct->product->cost_price,
                        'quantity' => $transferProduct->supply_qty,
                    ]);
                } else {
                    Medicine::create([
                        'category_id' => $category->id,
                        'brand_id' => $brand->id,
                        'name' => $transferProduct->product->product_name,
                        'selling_price' => $transferProduct->product->trade_price,
                        'buying_price' => $transferProduct->product->cost_price,
                        'description' => $transferProduct->product->package_detail,
                        'salt_composition' => $transferProduct->product->generic->formula,
                        'quantity' => $transferProduct->supply_qty,
                        'currency_symbol' => 'Rs',
                    ]);
                }
            }
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
            'stockReport' => $transfer->load(['transferProducts.product.group', 'transferProducts.product.generic', 'transferProducts.product.vendor', 'transferProducts.product.manufacturer', 'transferProducts.product.productCategory']),
        ]);
    }

    public function exportTransferReport()
    {
        $date = now();

        return (new TransferExport)->download('Transfer_Report'.$date.'.xlsx');
    }
}
