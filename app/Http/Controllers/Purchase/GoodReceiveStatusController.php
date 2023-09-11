<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Models\Purchase\GoodReceiveNote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

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
            'goodReceiveNote' => $goodReceiveNote->load(['goodReceiveProducts.product','requistion.vendor']),
        ]);
    }

    public function status(Request $request, GoodReceiveNote $goodReceiveNote): RedirectResponse
    {
        if ($request->status == 1) {
            foreach ($goodReceiveNote->goodReceiveProducts as $goodReceiveProduct) {
                $goodReceiveProduct->product->increment('total_quantity', $goodReceiveProduct->deliver_qty);
                $goodReceiveProduct->product->update(['cost_price' => $goodReceiveProduct->item_amount]);
            }
        }
        $goodReceiveNote->update([
            'is_approved' => $request->status
        ]);

        return back()->with('success', 'Good receive updated!');
    }
}