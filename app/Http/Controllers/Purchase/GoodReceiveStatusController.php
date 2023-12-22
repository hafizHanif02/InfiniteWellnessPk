<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Log;
use App\Models\Batch;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Purchase\GoodReceiveNote;
use App\Models\Purchase\GoodReceiveProduct;

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
        // dd($goodReceiveNote->goodReceiveProducts);
        if ($request->status == 1) {
            foreach ($goodReceiveNote->goodReceiveProducts as $goodReceiveProduct) {
                // $unit_trade = (($goodReceiveProduct->product->trade_price_percentage * $goodReceiveProduct->item_amount) / 100) + $goodReceiveProduct->item_amount;
                // $unit_trade = $goodReceiveProduct->item_amount - (($goodReceiveProduct->product->trade_price_percentage * $goodReceiveProduct->item_amount) / 100);
                // $manufacture_retail_price = $goodReceiveProduct->item_amount * $goodReceiveProduct->product->pieces_per_pack;
                // dd($manufacture_retail_price, $unit_trade);
                // $unit_retail = $goodReceiveProduct->manufacture_retail_price/$goodReceiveProduct->deliver_qty;
                $unit_retail = $goodReceiveProduct->manufacturer_retail_price / $goodReceiveProduct->product->pieces_per_pack;
                $formatted_unit_retail = number_format($unit_retail, 2);
                $quantity = $goodReceiveProduct->deliver_qty + $goodReceiveProduct->bonus;
                // dd($quantity);

                $batch =   Batch::create([
                    'batch_no' => $goodReceiveProduct->batch_number,
                    'product_id' => $goodReceiveProduct->product->id,
                    'unit_trade' => $goodReceiveProduct->item_amount,
                    'unit_retail' => $formatted_unit_retail,
                    'quantity' => $quantity,
                    'remaining_qty' => $quantity,
                    'expiry_date' => $goodReceiveProduct->expiry_date,
                    'transfer_quantity' => 0
                ]);
                GoodReceiveProduct::where('id', $goodReceiveProduct->id)->update([
                    'batch_id' => $batch->id
                ]);

                if ($goodReceiveProduct->bonus != NULL) {
                    $goodReceiveProduct->product->increment('total_quantity', $goodReceiveProduct->deliver_qty);
                    $goodReceiveProduct->product->increment('total_quantity', $goodReceiveProduct->bonus);
                } else {
                    $goodReceiveProduct->product->increment('total_quantity', $goodReceiveProduct->deliver_qty,);
                }

                // $goodReceiveProduct->product->update(['cost_price' => $goodReceiveProduct->item_amount]);

                //     $goodReceiveProduct->product->update([
                //     'manufacturer_retail_price'=> $goodReceiveProduct->manufacture_retail_price,
                //     'unit_trade' => $unit_trade,
                //     // 'unit_retail'=> $goodReceiveProduct->item_amount
                // ]);

                // dd($goodReceiveProduct->manufacturer_retail_price/$goodReceiveProduct->deliver_qty, $goodReceiveProduct->item_amount, $goodReceiveProduct->manufacturer_retail_price);
                $goodReceiveProduct->product->update([
                    'unit_retail' => $formatted_unit_retail,
                    'unit_trade' => $goodReceiveProduct->item_amount,
                    'manufacturer_retail_price' => $goodReceiveProduct->manufacturer_retail_price
                ]);
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
