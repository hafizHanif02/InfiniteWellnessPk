<?php

namespace App\Http\Controllers\Shift;

use App\Models\Log;
use App\Models\Batch;
use App\Models\BatchPOS;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Shift\Transfer;
use App\Exports\StockOutExport;
use App\Models\Inventory\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Shift\TransferProduct;
use Illuminate\Http\RedirectResponse;
use App\Imports\Inventory\ProductImport;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Shift\TransferRequest;

class TransferController extends Controller
{
    public function index(): View
    {
        return view('shift.transfer.index', [
            'transfers' => Transfer::latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function importExcel(Request $request)
    {
        return "testing";
        Excel::import(new TransferProductImport, storage_path('app/public/' . request()->file('transfer-products_csv')->store('transfer-products-excel-files', 'public')));

        return back()->with('success', 'Imported successfully!');
    }

    public function printReport()
    {
        return (new StockOutExport)->download('stock-out-report.xlsx');
    }

    public function create(): View
    {
    
        return view('shift.transfer.create', [
            'products' => Product::orderBy('product_name')->with('batch')->get(),
            'transfer_id' => Transfer::latest()->pluck('id')->first(),
            'transfers' => Transfer::with('transferProducts.product')->get(),
        ]);
    }

    // public function validateTransfer(Request $request)
    // {


    //     $customMessages = [
    //         'products.required' => 'At least one product is required',
    //         'products.*.total_piece' => 'Product Quantity Should be added Correctly',
    //     ];

    //     if ($request->product_id) {
    //         $p_id = $request->product_id;
    //         $product = Product::where('id', $p_id)->first();
    //         $max_qty = $product->total_quantity;

    //         $validatedData = $request->validate([
    //             'supply_date' => ['required', 'date'],
    //             'products' => ['required'],
    //             'products.*.id' => ['required', 'exists:products,id'],
    //             'products.*.unit_of_measurement' => ['required', 'integer', 'in:0,1'],
    //             'products.*.price_per_unit' => ['required', 'numeric'],
    //             'products.*.total_piece' => ['required', 'integer', 'min:1', "max:$max_qty"],
    //             'products.*.total_pack' => ['required', 'integer'],
    //             'products.*.amount' => ['required', 'numeric'],
    //         ], $customMessages);
    //     } else {
    //         $customMessages = [
    //             'products.required' => 'At least one product is required',
    //         ];

    //         $validator = Validator::make($request->all(), [
    //             'supply_date' => ['required', 'date'],
    //             'products' => ['required', 'array'],
    //             'products.*.id' => ['required', 'exists:products,id'],
    //         ]);

    //         $validationErrors = [];

    //         if ($validator->fails()) {
    //             $validationErrors['global'] = 'Global validation error message';
    //         }

    //         foreach ($request->products as $key => $product) {
    //             $p_id = $product['id'];
    //             $inventoryProduct = Product::find($p_id);

    //             if (!$inventoryProduct) {
    //                 $validationErrors['products.' . $key . '.id'] = 'Product not found';
    //             } else {
    //                 $max_qty = $inventoryProduct->total_quantity;

    //                 $productValidator = Validator::make($product, [
    //                     'unit_of_measurement' => ['required', 'integer', 'in:0,1'],
    //                     'price_per_unit' => ['required', 'numeric'],
    //                     'total_piece' => ['required', 'integer', 'min:1', "max:$max_qty"],
    //                     'total_pack' => ['required', 'integer'],
    //                     'amount' => ['required', 'numeric'],
    //                 ]);

    //                 if ($productValidator->fails()) {
    //                     $validationErrors['products.' . $key] = $productValidator->errors();
    //                 }
    //             }
    //         }

    //         if (!empty($validationErrors)) {
    //             return response()->json(['valid' => false, 'message' => 'Product is not added Correctly !', 'errors' => $validationErrors]);
    //         }

    //         // Validation succeeded
    //         return response()->json(['valid' => true, 'message' => 'Validation succeeded']);

    //     }

    //     return response()->json(['valid' => true, 'message' => 'Validation succeeded.']);
    // }

    public function validateTransfer(Request $request)
    {
        $customMessages = [
            'products.required' => 'At least one product is required',
            'products.*.total_piece.max' => 'Product Quantity should not exceed :max',
            'products.*.batch_no.required' => 'Batch information is required for each product',
            
        ];
    
        $rules = [
            'supply_date' => ['required', 'date'],
            'products' => ['required', 'array'],

        ];
    
        if ($request->product_id) {
            $rules['products.*.id'] = ['required', 'exists:products,id'];
            $rules['products.*.unit_of_measurement'] = ['required', 'integer', 'in:0,1'];
            $rules['products.*.price_per_unit'] = ['required', 'numeric'];
            $rules['products.*.total_pack'] = ['required', 'integer'];
            $rules['products.*.amount'] = ['required', 'numeric'];
            $rules['products.*.batch_no'] = ['required']; 
        }
    
        $validationErrors = [];
    
        foreach ($request->products as $key => $product) {
            $p_id = $product['id'];
            $inventoryProduct = Product::find($p_id);
            $batch = Batch::where('id', $product['batch_no'])->first();
            
            if (!$inventoryProduct) {
                $validationErrors['products.' . $key . '.id'] = 'Product not found';
            } else {
                $max_qty = $inventoryProduct->total_quantity;
                $remaining_qty = $batch ? $batch->remaining_qty : 0;
    
                $productValidator = Validator::make($product, [
                    'unit_of_measurement' => ['required', 'integer', 'in:0,1'],
                    'price_per_unit' => ['required', 'numeric'],
                    'total_piece' => ['required', 'integer', 'min:1', "max:$remaining_qty"],
                    'total_pack' => ['required', 'integer'],
                    'amount' => ['required', 'numeric'],
                    'batch_no' => ['required'], 
                ], $customMessages);
    
                if ($productValidator->fails()) {
                    $validationErrors['products.' . $key] = $productValidator->errors();
                }
            }
        }
    
        if (!empty($validationErrors)) {
            return response()->json(['valid' => false, 'message' => 'Product is not added correctly!', 'errors' => $validationErrors]);
        }
    
        return response()->json(['valid' => true, 'message' => 'Validation succeeded']);
    }
    


    public function products($product): JsonResponse
    { 
        return response()->json([
            'product' => Product::where('id',$product)->with('batch')->first(),
        ]);
    }

    public function store(TransferRequest $request): RedirectResponse
    {
        $transfer = Transfer::create([
            'supply_date' => $request->supply_date
        ]);
        $user = Auth::user();
        $requistionproductlogs = 'Transfer No. '.$transfer->id.' Products:{[produc_id, qty],';
            foreach ($request->products as $product) {

            $transferProduct = TransferProduct::create([
                'transfer_id' => $transfer->id,
                'product_id' => $product['id'],
                'batch_id' => $product['batch_no'],
                'unit_of_measurement' => $product['unit_of_measurement'],
                'price_per_unit' => $product['price_per_unit'],
                'total_piece' => $product['total_piece'],
                'unit_trade' => $product['price_per_unit_unitonly'],
                'total_pack' => $product['total_pack'],
                'amount' => $product['amount']
            ]);
            
        //     if($product['batch_no'] != null){
        //     $batch = Batch::where('id', $product['batch_no'])->first();

            
        //     if($batch->quantity >= $product['total_piece']){
        //         Batch::where('id', $product['batch_no'])->update([
        //             'transfer_quantity' => $batch->transfer_quantity + $product['total_piece'],
        //             'remaining_qty' => $batch->remaining_qty - $product['total_piece'],
        //         ]);
        //         $batchpos = BatchPOS::where('product_id', $product['id'])->where('batch_id', $product['batch_no'])->first();

        //         if($batchpos){
        //             if($batchpos->batch_id == $batch->id ){
        //                 BatchPOS::increment('quantity', $product['total_piece']);
        //                 BatchPOS::increment('remaining_qty', $product['total_piece']);
        //             }else{
        //                 BatchPOS::create([
        //                    'batch_id' => $product['batch_no'],
        //                    'product_id'=>$product['id'],
        //                    'unit_trade'=>$product['price_per_unit_unitonly'],
        //                    'unit_retail'=>$batch->unit_retail,
        //                    'quantity'=>$product['total_piece'],
        //                    'remaining_qty'=>$product['total_piece'],
        //                    'expiry_date'=>$batch->expiry_date,
        //                    'sold_quantity'=>0,
        //                 ]);
        //             }
        //         }else{
        //             BatchPOS::create([
        //                'batch_id' => $product['batch_no'],
        //                'product_id'=>$product['id'],
        //                'unit_trade'=>$product['price_per_unit_unitonly'],
        //                'unit_retail'=>$batch->unit_retail,
        //                'quantity'=>$product['total_piece'],
        //                'remaining_qty'=>$product['total_piece'],
        //                'expiry_date'=>$batch->expiry_date,
        //                'sold_quantity'=>0,
        //             ]);
        //         } 
        //     }
        //     else{
        //         return redirect()->back()->with('success', 'Insufficient Stock!');
        //     }
        // }

            $requistionproductlogs .= '['.$product['id'].','.$product['total_piece'].'],'; 
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Transfer Has Been Created Transfer No.'.$transfer->id ,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'log/' . $logs->id . '.txt'; 
        $filePath = public_path($fileName); 
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);

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

        $transferProduct = TransferProduct::where('transfer_id', $transferId)->with('product.batch')->get();

        if (!$transferProduct) {
            return response()->json(['message' => 'Transfer not found'], 404);
        }

        return response()->json($transferProduct);
    }

    public function getBatch($batchId)
    {
        $batch = Batch::where('id', $batchId)->first();
        $productBatch = Batch::where('product_id', $batch->product_id)->get();

        return response()->json([
            'productBatch' => $productBatch,
        ]);
    }
}
