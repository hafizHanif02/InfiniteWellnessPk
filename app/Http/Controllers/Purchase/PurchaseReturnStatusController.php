<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Log;
use App\Models\Batch;
use Illuminate\View\View;
use App\Models\Inventory\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Purchase\GoodReceiveProduct;
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
        dd($request);
        if ($request->status == 1) {
            Product::where('id', $purchaseReturnStatus->product_id)->decrement(
                'total_quantity', $purchaseReturnStatus->quantity
            );
        }

        $batches_id = GoodReceiveProduct::where('batch_id', $purchaseReturnStatus->batch_id)->get()->pluck('batch_id');
        // dd(($batches_id));
        foreach ($batches_id as $batch_id) {
            // Use isset to check if $batch_id exists
            if (isset($batch_id)) {
                Batch::where('id', $batch_id)->decrement([
                    'quantity' => $purchaseReturnStatus->quantity,
                ]);
            }
        }
        
        $purchaseReturnStatus->update([
            'status' => $request->status,
        ]);


        $user = Auth::user();
        Log::create([
            'action' => 'Purchase Return Note Has Been ' . ($request->status == 1 ? 'Approved' : 'Rejected') . ' GRN No.' . $purchaseReturnStatus->good_receive_note_id.' Products ID:'.$purchaseReturnStatus->product_id,
            'action_by_user_id' => $user->id,
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
