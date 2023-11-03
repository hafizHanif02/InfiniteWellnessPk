<?php

namespace App\Http\Controllers\Purchase;

use Illuminate\View\View;
use App\Models\Inventory\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Purchase\PurchaseReturnNote;
use App\Http\Requests\Purchase\PurchaseReturnStatusRequest;

class PurchaseReturnStatusController extends Controller
{
    public function index(): View
    {
        return view('purchase.purchase-return-status.index', [
            'purchasereturns' => PurchaseReturnNote::with('goodReceiveNote')->with('product')->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function show($return): View
    {
        return view('purchase.purchase-return-status.show', [
            'purchasereturn' => PurchaseReturnNote::where('id',$return)->with(['goodReceiveNote', 'product'])->first(),
        ]);
    }

    public function update(PurchaseReturnStatusRequest $request, PurchaseReturnNote $purchaseReturnStatus): RedirectResponse
    {
        // dd($purchaseReturnStatus);
        if ($request->status == 1) {
            Product::where('id', $purchaseReturnStatus->product_id)->decrement(
                'total_quantity', $purchaseReturnStatus->quantity
            );
        }
        
        $purchaseReturnStatus->update([
            'status' => $request->status,
        ]);

        return to_route('purchase.purchase-return-status.index')->with('success', 'Purchase status updated!');
    }


    // public function retransfer($purchaseretrun){
    //     $return = PurchaseReturnNote::where('id',$purchaseretrun)->with('product')->first();
    //     return view('purchase.purchasereturn.retransfer',[
    //         'return' => $return
    //     ]);
    // }
    public function retransfer($purchaseretrun){
        $return = PurchaseReturnNote::where('id',$purchaseretrun)->update([
            'status' => null
        ]);
        return to_route('purchase.purchase-return-status.index')->with('success', 'Purchase status rescheduled!');
    }
}
