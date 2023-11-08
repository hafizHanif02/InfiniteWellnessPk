<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Log;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Inventory\Vendor;
use Illuminate\Http\JsonResponse;
use App\Models\Purchase\Requistion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Purchase\RequistionProduct;
use App\Http\Requests\Purchase\RequistionRequest;

class PurchaseOrderListController extends Controller
{
    public function index(Request $request): View
    {
        return view('purchase.purchase-order-list.index', [
            'purchaseOrders' => Requistion::with(['vendor', 'requistionProducts.product'])->filter($request)->latest()->paginate(10)->onEachSide(1),
            'vendors' => Vendor::orderBy('contact_person')->get(),
        ]);
    }

    public function filter(Request $request): JsonResponse
    {
        
        return response()->json([
            'data' => Requistion::with(['vendor', 'requistionProducts.product'])->filter($request)->latest()->get(),
        ]);
    }

    public function show(Requistion $purchaseorderlist): View
    {
        return view('purchase.purchase-order-list.show', [
            'requistion' => $purchaseorderlist->load('requistionProducts.product'),
        ]);
    }

    public function edit(Requistion $purchaseorderlist): View
    {
        return view('purchase.purchase-order-list.edit', [
            'requistion' => $purchaseorderlist->load(['requistionProducts.product', 'vendor.manufacturer']),
            'vendors' => Vendor::orderBy('account_title')->get(['id', 'account_title']),
        ]);
    }

    public function update(RequistionRequest $request, Requistion $purchaseorderlist): RedirectResponse
    {
        $purchaseorderlist->update([
            'remarks' => $request->remarks,
            'delivery_date' => $request->delivery_date,
            'is_updated' => 1
        ]);

        $purchaseorderlist->requistionProducts()->delete();
        $user = Auth::user();
        $requistionproductlogs = 'Requistion No. '.$purchaseorderlist->id.' Products:{[produc_id, qty],';
        foreach ($request->products as $product) {
            RequistionProduct::create([
                'requistion_id' => $purchaseorderlist->id,
                'product_id' => $product['id'],
                'limit' => $product['limit'],
                'price_per_unit' => $product['price_per_unit'],
                'total_piece' => $product['total_piece'],
                'total_amount' => $product['total_amount'],
            ]);
            $requistionproductlogs .= '['.$product['id'].','.$product['total_piece'].'],'; 
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Purchase Order Has Been Updated Requistion No.'.$purchaseorderlist->id ,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'log/' . $logs->id . '.txt'; 
        $filePath = public_path($fileName); 
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);

        return to_route('purchase.purchaseorderlist.index')->with('success', 'Purchase Order updated!');
    }

    public function print(Requistion $requistionId): View
    {
        $totalcost = 0;
        foreach ($requistionId->requistionProducts as $requistionProduct) {
            $totalcost += $requistionProduct->total_amount;
        }
        $totalDiscount = 0;
        foreach ($requistionId->requistionProducts as $requistionProduct) {
            $totalDiscount += $requistionProduct->disc_amount;
        }

        return view('purchase.purchase-order-list.print', [
            'requistion' => $requistionId->load(['requistionProducts.product.manufacturer', 'vendor']),
            'totalcost' => $totalcost,
            'totalDiscount' => $totalDiscount,
        ]);
    }
}
