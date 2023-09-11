<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Inventory\Vendor;
use App\Models\Inventory\Product;
use Illuminate\Http\JsonResponse;
use App\Models\Purchase\Requistion;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Purchase\RequistionProduct;
use App\Http\Requests\Purchase\RequistionRequest;

class PurchaseOrderController extends Controller
{
    public function index(): View
    {
        return view('purchase.purchaseorder.index', [
            'requistions' => Requistion::with('vendor')->where('is_approved', null)->paginate(10)->onEachSide(1),
        ]);
    }

    public function products(Request $request): JsonResponse
    {
        return response()->json([
            'data' => Product::where('vendor_id', $request->vendor_id)->get(['id', 'product_name']),
            'manufacturer' => Vendor::where('id', $request->vendor_id)->with('manufacturer')->first(),
        ]);
    }

    public function show(Requistion $purchaseorder): View
    {
        return view('purchase.purchaseorder.show', [
            'requistion' => $purchaseorder->load('requistionProducts.product'),
        ]);
    }

    public function edit(Requistion $purchaseorder): View
    {
        return view('purchase.purchaseorder.edit', [
            'requistion' => $purchaseorder->load(['requistionProducts.product', 'vendor.manufacturer']),
            'vendors' => Vendor::orderBy('account_title')->get(['id', 'account_title']),
        ]);
    }

    public function update(RequistionRequest $request, Requistion $purchaseorder): RedirectResponse
    {
        $purchaseorder->update([
            'remarks' => $request->remarks,
            'delivery_date' => $request->delivery_date
        ]);

        $purchaseorder->requistionProducts()->delete();
        foreach ($request->products as $product) {
            RequistionProduct::create([
                'requistion_id' => $purchaseorder->id,
                'product_id' => $product['id'],
                'limit' => $product['limit'],
                'price_per_unit' => $product['price_per_unit'],
                'total_piece' => $product['total_piece'],
                'total_amount' => $product['total_amount'],
            ]);
        }

        return to_route('purchase.purchaseorder.index')->with('success', 'Purchase order updated!');
    }

    public function status(Request $request, Requistion $requistion): RedirectResponse
    {
        $requistion->update([
            'is_approved' => $request->status,
            'purchase_order_date' => now(),
        ]);

        return back()->with('success', 'Requistion updated!');
    }
}
