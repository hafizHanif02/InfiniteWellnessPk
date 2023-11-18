<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Log;
use Illuminate\View\View;
use App\Models\Inventory\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Purchase\GoodReceiveNote;
use App\Models\Purchase\GoodReceiveProduct;
use App\Models\Purchase\PurchaseReturnNote;
use App\Http\Requests\Purchase\PurchaseReturnRequest;

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
            'goodReceiveNotes' => GoodReceiveNote::with('goodReceiveProducts.batch')->latest()->get(['id']),
        ]);
    }

    public function returnProductList(int $goodReceiveNoteId): JsonResponse
    {
        return response()->json([
            'products' => GoodReceiveProduct::where('good_receive_note_id', $goodReceiveNoteId)->with(['product','goodReceiveNote','batch'])->get(),
        ]);
    }

    public function store(PurchaseReturnRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $requistionproductlogs = 'Purchase Return GRN No:'.$request->good_receive_note_id.' Products:{[produc_id, qty],';
        foreach ($request->products as $product) {
            $purchaseReturn = PurchaseReturnNote::create([
                'good_receive_note_id' => $request->good_receive_note_id,
                'product_id' => $product['id'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);

            $requistionproductlogs .= '['.$product['id'].','.$product['quantity'].'],'; 
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Purchase Return Has Been Created GRN No.'.$request->good_receive_note_id ,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'log/' . $logs->id . '.txt'; 
        $filePath = public_path($fileName); 
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);
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
        $user = Auth::user();
        Log::create([
            'action' => 'Purchase Return Has Been Deleted GRN No.'.$return->good_receive_note_id.' Product ID:'.$return->product_id, 
            'action_by_user_id' => $user->id,
        ]);
        $return->delete();

        return to_route('purchase.return.index')->with('success', 'Purchase Return Deleted!');
    }
}
