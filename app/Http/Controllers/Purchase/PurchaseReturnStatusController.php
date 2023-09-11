<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\PurchaseReturnStatusRequest;
use App\Models\Purchase\PurchaseReturnNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PurchaseReturnStatusController extends Controller
{
    public function index(): View
    {
        return view('purchase.purchase-return-status.index', [
            'purchasereturns' => PurchaseReturnNote::with('goodReceiveNote')->with('product')->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function show(PurchaseReturnNote $return): View
    {
        return view('purchase.purchase-return-status.show', [
            'purchasereturn' => $return->load(['goodReceiveNote', 'product']),
        ]);
    }

    public function update(PurchaseReturnStatusRequest $request, PurchaseReturnNote $purchaseReturnStatus): RedirectResponse
    {
        if($request->status === 1) {
            $purchaseReturnStatus->product->decrementEach([
                'cost_price' => $purchaseReturnStatus->price,
                'total_quantity' => $purchaseReturnStatus->quantity,
            ]);
        }
        $purchaseReturnStatus->update([
            'status' => $request->status,
        ]);

        return to_route('purchase.purchase-return-status.index')->with('success', 'Purchase status updated!');
    }
}
