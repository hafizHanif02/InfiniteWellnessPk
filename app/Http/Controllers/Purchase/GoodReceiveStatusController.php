<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Log;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Purchase\GoodReceiveNote;

class GoodReceiveStatusController extends Controller
{
    public function index(): View
    {
        return view('purchase.goodreceivestatus.index', [
            'goodReceiveNotes' => GoodReceiveNote::with('requistion')->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function show(GoodReceiveNote $goodReceiveNote): View
    {
        return view('purchase.goodreceivestatus.show', [
            'goodReceiveNote' => $goodReceiveNote->load(['goodReceiveProducts.product', 'requistion.vendor']),
        ]);
    }

    public function status(Request $request, GoodReceiveNote $goodReceiveNote): RedirectResponse
    {
        if ($request->status == 1) {
            foreach ($goodReceiveNote->goodReceiveProducts as $goodReceiveProduct) {
                $unit_trade = (($goodReceiveProduct->product->trade_price_percentage * $goodReceiveProduct->item_amount) / 100) + $goodReceiveProduct->item_amount;

                if ($goodReceiveProduct->bonus != NULL) {
                    $goodReceiveProduct->product->increment('total_quantity', $goodReceiveProduct->deliver_qty);
                    $goodReceiveProduct->product->increment('total_quantity', $goodReceiveProduct->bonus);

                }else{
                    $goodReceiveProduct->product->increment('total_quantity', $goodReceiveProduct->deliver_qty,);
                }

                $goodReceiveProduct->product->update(['cost_price' => $goodReceiveProduct->item_amount]);
                $goodReceiveProduct->product->update(['unit_trade' => $unit_trade]);
            }
        }
        $goodReceiveNote->update([
            'is_approved' => $request->status
        ]);
        $user = Auth::user();
        Log::create([
            'action' => 'Good Receive Note Has Been ' . ($request->status == 1 ? 'Approved' : 'Rejected') . ' GRN No.' . $goodReceiveNote->id,
            'action_by_user_id' => $user->id,
        ]);

        return back()->with('success', 'Good receive updated!');
    }
}
