<?php

namespace App\Http\Controllers\Shift;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Shift\Transfer;
use App\Exports\StockOutExport;
use App\Models\Inventory\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Shift\TransferProduct;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Shift\TransferRequest;

class TransferController extends Controller
{
    public function index(): View
    {
        return view('shift.transfer.index', [
            'transfers' => Transfer::latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function printReport()
    {
        return (new StockOutExport)->download('stock-out-report.xlsx');
    }

    public function create(): View
    {
        return view('shift.transfer.create', [
            'products' => Product::orderBy('product_name')->get(),
            'transfer_id' => Transfer::latest()->pluck('id')->first(),
            'transfers' => Transfer::with('transferProducts.product')->get(),
        ]);
    }

    public function products(Product $product): JsonResponse
    {
        return response()->json([
            'product' => $product,
        ]);
    }

    public function store(TransferRequest $request): RedirectResponse
    {
        $transfer = Transfer::create([
            'supply_date' => $request->supply_date
        ]);

        foreach ($request->products as $product) {
            $transferProduct = TransferProduct::create([
                'transfer_id' => $transfer->id,
                'product_id' => $product['id'],
                'unit_of_measurement' => $product['unit_of_measurement'],
                'price_per_unit' => $product['price_per_unit'],
                'total_piece' => $product['total_piece'],
                'total_pack' => $product['total_pack'],
                'amount' => $product['amount']
            ]);

        }

        return to_route('shift.transfers.index')->with('success', 'Transfer created!');
    }

    public function show(Transfer $transfer): View
    {
        return view('shift.transfer.show', [
            'transfer' => $transfer->load('transferProducts.product'),
        ]);
    }

    public function retransfer($transferId)
    {
        
         $transferProduct = TransferProduct::where('transfer_id',$transferId)->with('product')->get();

         if (!$transferProduct) {
             return response()->json(['message' => 'Transfer not found'], 404);
         }
        //  dd($transferProduct);
 
         return response()->json($transferProduct);
    }

}
