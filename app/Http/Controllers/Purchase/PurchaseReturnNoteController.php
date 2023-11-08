<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\PurchaseReturnRequest;
use App\Models\Inventory\Product;
use App\Models\Purchase\GoodReceiveNote;
use App\Models\Purchase\GoodReceiveProduct;
use App\Models\Purchase\PurchaseReturnNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PurchaseReturnNoteController extends Controller
{
    public function index(): View
    {
        return view('purchase.purchasereturn.index', [
            'purchasereturns' => PurchaseReturnNote::where('status', null)->with('goodReceiveNote')->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function create(): View
    {
        return view('purchase.purchasereturn.create', [
            'goodReceiveNotes' => GoodReceiveNote::latest()->get(['id']),
        ]);
    }

    public function returnProductList(int $goodReceiveNoteId): JsonResponse
    {
        return response()->json([
            'products' => GoodReceiveProduct::where('good_receive_note_id', $goodReceiveNoteId)->with(['product','goodReceiveNote'])->get(),
        ]);
    }

    public function store(PurchaseReturnRequest $request): RedirectResponse
    {
        
        foreach ($request->products as $product) {
            PurchaseReturnNote::create([
                'good_receive_note_id' => $request->good_receive_note_id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        return to_route('purchase.return.index')->with('success', 'Purchase Return Added!');
    }

    public function show($return): View
    {
        return view('purchase.purchasereturn.show', [
            'purchasereturn' => PurchaseReturnNote::with(['goodReceiveNote', 'product'])->find($return),
        ]);
    }

    public function destroy(PurchaseReturnNote $return): RedirectResponse
    {
        $return->delete();

        return to_route('purchase.return.index')->with('success', 'Purchase Return Deleted!');
    }
}
