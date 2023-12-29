<?php

namespace App\Http\Controllers\Purchase;

use Carbon\Carbon;
use App\Models\Log;
use App\Models\Pos;
use App\Models\Batch;
use App\Models\BatchPOS;
use App\Models\PosReturn;
use Illuminate\View\View;
use App\Models\GrnPayment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Shift\Transfer;
use App\Models\Inventory\Vendor;
use App\Models\Inventory\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase\Requistion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Shift\TransferProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Exists;
use App\Models\Purchase\GoodReceiveNote;
use Illuminate\Support\Facades\Validator;
use App\Models\Purchase\RequistionProduct;
use App\Models\Purchase\GoodReceiveProduct;
use App\Http\Requests\Purchase\GoodReceiveNoteRequest;

class GoodReceiveNoteController extends Controller
{
    public function index(): View
    {
        return view('purchase.goodreceivenote.index', [
            'goodReceiveNotes' => GoodReceiveNote::with('requistion.vendor')->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function create(): View
    {
        return view('purchase.goodreceivenote.create', [
            'id' => GoodReceiveNote::latest()->pluck('id')->first(),
            'vendors' => Vendor::orderBy('account_title')->get(['id', 'account_title']),
        ]);
    }
    public function getRequisitions($vendorId): JsonResponse
    {
        return response()->json([
            'requistions' => Requistion::where(['vendor_id' => $vendorId, 'is_approved' => 1])->get(),
        ]);
    }

    public function getRequisitionProducts($requistionId): JsonResponse
    {
        return response()->json([
            'requistionProducts' => RequistionProduct::where('requistion_id', $requistionId)->with('product')->get(),
        ]);
    }

    public function store(GoodReceiveNoteRequest $request): RedirectResponse
    {


        // dd($request->products);
        $goodReceiveNote = GoodReceiveNote::create([
            'invoice_date' => $request->invoice_date,
            'invoice_number' => $request->invoice_number,
            'requistion_id' => $request->requistion_id,
            'remark' => $request->remark,
            'date' => $request->date,
            'bonus' => $request->bonus,
            'total_amount' => $request->total_amount,
            'total_discount_amount' => $request->total_discount_amount,
            'net_total_amount' => $request->net_total_amount,
            'advance_tax_percentage' => $request->advance_tax_percentage,
            'advance_tax_amount' => $request->advance_tax_amount,
            'sale_tax_percentage' => $request->sale_tax_percentage,
        ]);
        $user = Auth::user();
        $requistionproductlogs = 'GRN No. ' . $goodReceiveNote->id . ' Products:{[produc_id, qty],';
        foreach ($request->products as $product) {
            $requistion = RequistionProduct::where(['requistion_id' => $request->requistion_id, 'product_id' => $product['id']])->with('product')->first();
            //   $batch =   Batch::create([
            //         'batch_no' => $product['batch_no'],
            //        'product_id' => $product['id'],
            //        'unit_trade' => $requistion->product->unit_trade,
            //        'unit_retail' => $requistion->product->unit_retail,
            //        'quantity' => $product['deliver_qty'],
            //        'remaining_qty' => $product['deliver_qty'],
            //        'expiry_date' => $product['expiry_date'],
            //     'transfer_quantity' => 0
            //   ]);


            GoodReceiveProduct::create([
                'good_receive_note_id' => $goodReceiveNote->id,
                'product_id' => $product['id'],
                'deliver_qty' => $product['deliver_qty'],
                'bonus' => $product['bonus'] ?? null,
                'expiry_date' => $product['expiry_date'],
                'item_amount' => $product['totalprice2'],
                'batch_number' => $product['batch_no'],
                'discount' => $product['discount'],
                'saletax_percentage' => $product['saletax_percentage'],
                'saletax_amount' => $product['saletax_amount'],
                'manufacturer_retail_price' => $product['manufacturer_retail_price'],
                // 'batch_id' => $batch->id,
            ]);


            $grnProduct = GoodReceiveNote::where('id', $goodReceiveNote->id)->with('goodReceiveProducts')->first();


            foreach ($grnProduct->goodReceiveProducts as $goodReceiveProduct) {
                $unit_retail = $goodReceiveProduct->manufacturer_retail_price / $goodReceiveProduct->product->pieces_per_pack;
                $formatted_unit_retail = number_format($unit_retail, 2);
                $quantity = $goodReceiveProduct->deliver_qty + $goodReceiveProduct->bonus;

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
            $goodReceiveNote->update([
                'is_approved' => 1
            ]);
            $user = Auth::user();
            Log::create([
                'action' => 'Good Receive Note Has Been ' . ($request->status == 1 ? 'Approved' : 'Rejected') . ' GRN No.' . $goodReceiveNote->id,
                'action_by_user_id' => $user->id,
            ]);















            $requistionproductlogs .= '[' . $product['id'] . ',' . $product['deliver_qty'] . '],';
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Good Receive Note Has Been Created GRN No.' . $goodReceiveNote->id,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'log/' . $logs->id . '.txt';
        $filePath = public_path($fileName);
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);

        return to_route('purchase.good_receive_note.index')->with('success', 'GRN created!');
    }

    public function show(GoodReceiveNote $goodReceiveNote): View
    {
        return view('purchase.goodreceivenote.show', [
            'goodReceiveNote' => $goodReceiveNote->load(['goodReceiveProducts.product', 'requistion.vendor']),
            'GrnProducts' => GoodReceiveProduct::where('good_receive_note_id', $goodReceiveNote->id)->with('requistionProduct.requistion.vendor')->with('goodReceiveNote')->get(),
        ]);
    }

    public function edit($goodReceiveNote): View
    {
        return view('purchase.goodreceivenote.edit', [
            'goodReceiveNote' => GoodReceiveNote::where('id', $goodReceiveNote)->with(['goodReceiveProducts.product', 'goodReceiveProducts.requistionProduct'])->first(),
            'vendors' => Vendor::orderBy('contact_person')->get(),
        ]);
    }

    public function update(GoodReceiveNoteRequest $request, GoodReceiveNote $goodReceiveNote): RedirectResponse
    {

        $goodReceiveNote->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'remark' => $request->remark,
            'date' => $request->date,
            'bonus' => $request->bonus,
            'total_amount' => $request->total_amount,
            'total_discount_amount' => $request->total_discount_amount,
            'net_total_amount' => $request->net_total_amount,
            'advance_tax_percentage' => $request->advance_tax_percentage,
            'sale_tax_percentage' => $request->sale_tax_percentage,
            'advance_tax_amount' => $request->sale_tax_percentage,
        ]);
        $user = Auth::user();
        $requistionproductlogs = 'GRN No. ' . $goodReceiveNote->id . ' Products:{[produc_id, qty],';
        foreach ($request->products as $product) {
            $product_id = $product['id'];
            GoodReceiveProduct::where(['product_id' => $product_id, 'good_receive_note_id' => $goodReceiveNote->id])->update([
                'deliver_qty' => $product['deliver_qty'],
                'bonus' => $product['bonus'] ?? null,
                'expiry_date' => $product['expiry_date'],
                'item_amount' => $product['totalprice2'],
                'batch_number' => $product['batch_no'],
                'discount' => $product['discount'],
                'saletax_percentage' => $product['saletax_percentage'],
                'saletax_amount' => $product['saletax_amount'],
                'manufacturer_retail_price' => $product['manufacturer_retail_price'],
            ]);
            $requistionproductlogs .= '[' . $product['id'] . ',' . $product['deliver_qty'] . '],';
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Good Receive Note Has Been Updated GRN No.' . $goodReceiveNote->id,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'log/' . $logs->id . '.txt';
        $filePath = public_path($fileName);
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);

        return to_route('purchase.good_receive_note.index')->with('success', 'GRN updated!');
    }

    public function destroy(GoodReceiveNote $goodReceiveNote): RedirectResponse
    {
        $user = Auth::user();
        Log::create([
            'action' => 'Good Receive Note Has Been Deleted GRN No.' . $goodReceiveNote->id,
            'action_by_user_id' => $user->id,
        ]);
        $goodReceiveNote->delete();

        return back()->with('success', 'GRN deleted!');
    }

    public function print($goodReceiveNote): View
    {

        // $goodreceiveproduct = GoodReceiveProduct::where('good_receive_note_id', $goodReceiveNote->id)->with('product')->get();

        // $totalproductamount = 0;
        // foreach ($goodreceiveproduct as $product) {
        //     $totalproductamount += $product->item_amount;
        // }
        //requistion_id
        $grn = GoodReceiveNote::where('id', $goodReceiveNote)->with(['requistion.requistionProducts.product.manufacturer', 'requistion.vendor', 'goodReceiveProducts'])->first();
        $rec = Requistion::where('id', $grn->requistion_id)->first();
        $manuFacname = DB::table('manufacturers')->where('id', $rec->manufacturer_id)->first();
        return view('purchase.goodreceivenote.print', [
            'goodReceiveNote' => $grn,
            'grnManufactureName' => $manuFacname->company_name,
            // 'goodreceiveproduct' => $goodreceiveproduct,
            // 'totalproductamount' => $totalproductamount,
        ]);
    }

    public function validateGoodReceiveNote(Request $request)
    {
        $customMessages = [
            'requistion_id.required' => 'The Requisition is required.',
            'requistion_id.exists' => 'The Requisition does not exist in the database.',
            'date.required' => 'The date is required.',
            'total_amount.required' => 'The total amount is required.',
            'total_amount.numeric' => 'The total amount must be a number.',
            'total_amount.min' => 'The total amount must be at least :min.',
        ];

        $validatedData = $request->validate([
            'requistion_id' => ['required', 'exists:requistions,id'],
            'remark' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'total_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'net_total_amount' => ['required', 'numeric', 'min:0'],
            'advance_tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'advance_tax_amount' => ['nullable', 'numeric', 'min:0'],
            'sale_tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'products.*' => ['required'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.deliver_qty' => ['required', 'integer', 'min:0'],
            'products.*.bonus' => ['nullable', 'integer', 'min:0'],
            'products.*.expiry_date' => ['required', 'date'],
            'products.*.batch_no' => ['required', 'min:0'],
            'products.*.totalprice2' => ['required', 'numeric', 'min:0'],
            'products.*.discount' => ['nullable', 'numeric', 'min:0'],
            'products.*.saletax_percentage' => ['nullable', 'numeric'],
            'products.*.saletax_amount' => ['nullable', 'numeric'],
            'products.*.manufacturer_retail_price' => ['required', 'numeric'],
        ], $customMessages);

        // Validation succeeded
        return response()->json(['valid' => true, 'message' => 'Validation succeeded.']);
    }

    // public function createBatch()
    // {
    //     $GRNProducts = GoodReceiveProduct::with('product')->get();

    //     foreach ($GRNProducts as $GRNProduct) {
    //         $unit_trade = $GRNProduct->item_amount - (($GRNProduct->product->trade_price_percentage * $GRNProduct->item_amount) / 100);
    //         $manufacture_retail_price = $GRNProduct->item_amount * $GRNProduct->product->pieces_per_pack;
    //         // $batchNumber = $GRNProduct->batch_number ?? Str::random(10);
    //         $batchNumber = $GRNProduct->batch_number ?? strtoupper(Str::random(3) . Str::random(3, '1234567890'));
    //         $quantity = $GRNProduct->deliver_qty + $GRNProduct->bonus;
    //         Batch::create([
    //             'batch_no' => $batchNumber,
    //             'product_id' => $GRNProduct->product_id,
    //             'unit_trade' => $unit_trade,
    //             'unit_retail' => $GRNProduct->product->unit_retail,
    //             'quantity' => $quantity,
    //             'remaining_qty' => $quantity,
    //             'expiry_date' => $GRNProduct->expiry_date,
    //             'transfer_quantity' => 0
    //         ]);
    //     }

    //     return "Done !";
    // }


    public function createBatch()
    {
        $GRNProducts = GoodReceiveProduct::with('product')->get();

        foreach ($GRNProducts as $GRNProduct) {
            $unit_trade = $GRNProduct->item_amount - (($GRNProduct->product->trade_price_percentage * $GRNProduct->item_amount) / 100);
            $manufacture_retail_price = $GRNProduct->item_amount * $GRNProduct->product->pieces_per_pack;
            $batchNumber = $GRNProduct->batch_number ?? strtoupper(Str::random(3) . Str::random(3, '1234567890'));
            $quantity = $GRNProduct->deliver_qty + $GRNProduct->bonus;
            $newBatch = Batch::create([
                'batch_no' => $batchNumber,
                'product_id' => $GRNProduct->product_id,
                'unit_trade' => $unit_trade,
                'unit_retail' => $GRNProduct->product->unit_retail,
                'quantity' => $quantity,
                'remaining_qty' => $quantity,
                'expiry_date' => $GRNProduct->expiry_date,
                'transfer_quantity' => 0
            ]);
            $GRNProduct->update([
                'batch_id' => $newBatch->id,
            ]);
        }

        return "Done !";
    }


    public function createBatchPOS()
    {
        $transfers = Transfer::with('transferProducts.product')->where('status', 1)->get();
        foreach ($transfers as $transfer) {
            foreach ($transfer->transferProducts as $transferProduct) {
                if ($transferProduct->product->batch) {
                    $batch = Batch::where('product_id', $transferProduct->product->id)->first();
                    // foreach($batchs as $batch){
                    $batch_id = BatchPOS::where('batch_id', $batch->id)->first();
                    // dd($batch_id);
                    // if(!$batch_id){
                    BatchPOS::create([
                        'batch_id' => $batch->id,
                        'product_id' => $transferProduct->product_id,
                        'unit_trade' => $batch->unit_trade,
                        'unit_retail' => $batch->unit_retail,
                        'quantity' => $transferProduct->total_piece,
                        'sold_quantity' => 0,
                        'remaining_qty' => $transferProduct->total_piece,
                        'expiry_date' => $batch->expiry_date,
                    ]);
                    // }
                    // }
                }
            }
        }


        return "Done !";
    }

    // public function transferBatch()
    // {
    //     $transfers = Transfer::where('status', 1)->get();
    //     foreach($transfers as $transfer)
    //     {
    //         $transferProduct = TransferProduct::where('transfer_id', $transfer->id)->get();
    //         foreach($transferProduct as $product)
    //         {
    //             $batches = Batch::where('product_id', $product->product_id)->where('remaining_qty', "!=" , 0)->get();
    //             if(count($batches) > 0){
    //                 foreach($batches as $batch)
    //                 {
    //                     if($product->total_piece <= $batch->remaining_qty)
    //                     {
    //                         Batch::where('id', $batch->id)->update([
    //                             'transfer_quantity' => $batch->transfer_quantity + $product->total_piece,
    //                             'remaining_qty' => $batch->remaining_qty - $product->total_piece,
    //                         ]);
    //                     }
    //                 }
    //             }else{
    //                 return $batches;
    //             }
    //         }
    //     }

    //     return $transfer;
    // }

    public function transferBatch()
    {
        $transfers = Transfer::where('status', 1)->get();

        foreach ($transfers as $transfer) {
            $transferProducts = TransferProduct::where('transfer_id', $transfer->id)->get();

            foreach ($transferProducts as $product) {
                $batches = Batch::where('product_id', $product->product_id)
                    ->where('remaining_qty', '>', 0)
                    ->get();

                $quantityToTransfer = $product->total_piece;

                foreach ($batches as $batch) {
                    // Distribute the transfer quantity among batches, updating each batch
                    $currentTransferQuantity = min($quantityToTransfer, $batch->remaining_qty);

                    Batch::where('id', $batch->id)->update([
                        'transfer_quantity' => $batch->transfer_quantity + $currentTransferQuantity,
                        'remaining_qty' => $batch->remaining_qty - $currentTransferQuantity,
                    ]);

                    $quantityToTransfer -= $currentTransferQuantity;
                }

                // Update the product quantity with the total transfer quantity
                $product->total_piece -= $product->total_piece - $quantityToTransfer;
            }
        }

        return $transfers;
    }

    public function PosProduct()
    {
        $allBatch = BatchPOS::all();
        foreach ($allBatch as $Onebatch) {
            $Onebatch->update([
                'sold_quantity' => 0,
                'remaining_qty' => $Onebatch->quantity
            ]);
        }
        $poses = Pos::with('PosProduct.medicine.product')->where('is_paid', 1)->get();

        foreach ($poses as $pos) {
            foreach ($pos->PosProduct as $product) {
                $remainingQuantity = $product->product_quantity;

                $batchPosList = BatchPOS::where('product_id', $product->medicine->product->id)
                    ->orderByDesc('created_at')
                    ->get();
                foreach ($batchPosList as $batchPos) {
                    $quantityToUpdate = min($batchPos->remaining_qty, $remainingQuantity);
                    // dd($quantityToUpdate,$batchPos->remaining_qty, $remainingQuantity );

                    $batchPos->update([

                        'remaining_qty' => ($batchPos->remaining_qty - $quantityToUpdate),
                        'sold_quantity' => ($batchPos->sold_quantity + $quantityToUpdate),
                    ]);

                    $remainingQuantity -= $quantityToUpdate;
                    if ($remainingQuantity == 0) {
                        break;
                    }
                }
            }
        }

        $posesReturn = PosReturn::with('Pos_Product_Return.medicine.product')->get();
        //return $posesReturn;
        foreach ($posesReturn as $pos) {
            //return $pos->Pos_Product_Return;
            foreach ($pos->Pos_Product_Return as $product) {
                $remainingQuantity = $product->product_quantity;

                $batchPosList = BatchPOS::where('product_id', $product->medicine->product->id)
                    ->orderByDesc('created_at')
                    ->get();
                foreach ($batchPosList as $batchPos) {
                    $quantityToUpdate = min($batchPos->sold_quantity, $remainingQuantity);
                    //dd($quantityToUpdate,$batchPos->remaining_qty, $remainingQuantity );
                    $batchPos->update([
                        'remaining_qty' => $batchPos->remaining_qty + $quantityToUpdate,
                        'sold_quantity' => $batchPos->sold_quantity - $quantityToUpdate,
                    ]);

                    $remainingQuantity -= $quantityToUpdate;
                    if ($remainingQuantity == 0) {
                        break;
                    }
                }
            }
        }
    }

    public function retailSet()
    {
        $products = Product::all();
        foreach ($products as $product) {
            $unitRetail = $product->manufacturer_retail_price / $product->pieces_per_pack;
            Product::where('id', $product->id)->update([
                'unit_retail' => $unitRetail
            ]);
        }
        return 'done';
    }

    public function batchUnitRetail()
    {
        // $batches = Batch::all();
        $products = Product::all();
        foreach ($products as $product) {

            $grnProducts = GoodReceiveProduct::where('product_id', $product->id)->get();
            foreach($grnProducts as $grnProduct){

                $batches = Batch::where('product_id', $product->id)->get();
                foreach($batches as $batch){

                    if($grnProduct->manufacturer_retail_price !== null){
                        $currentUnitRetail = $grnProduct->manufacturer_retail_price / $grnProduct->product->pieces_per_pack;
                        // $currentUnitRetail = number_format($currentUnitRetail, 2);
                        Batch::where('id', $grnProduct->batch_id)->update([
                            'unit_retail' => $currentUnitRetail 
                        ]);
                    }else{
                        $unitRetail = $product->manufacturer_retail_price / $product->pieces_per_pack;
                        // $unitRetail = number_format($unitRetail, 2);
                        Batch::where('id', $grnProduct->batch_id)->update([
                            'unit_retail' => $unitRetail
                        ]);
                    }

                }

            }

        }

        return 'done';
    }

    public function grnPayments()
    {
        $grnPayments = GrnPayment::with('grn.requistion.vendor')->get();
        return view('expenses.GRNPayments.index',
        [
            'grnPayments' => $grnPayments
        ]);
    }

    public function grnPaymentsCreate()
    {
        $grn = GoodReceiveNote::all();
        return view('expenses.GRNPayments.create',
        [
            'grn' => $grn
        ]);
    }

    public function getGrn(Request $request)
    {
        $grn = GoodReceiveNote::where('id', $request->id)->with('grnPayments')->first();
        return response()->json([
            'grn' => $grn,
        ]);
    }

    public function grnPaymentsStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grn_id' => 'required',
            'paid_amount' => 'required | numeric | min:1',
            'paid_date' => 'required | date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $grnPayments = new GrnPayment();
            $grnPayments->grn_id = $request->grn_id;
            $grnPayments->paid_amount = $request->paid_amount;
            $grnPayments->paid_date = $request->paid_date;
            $grnPayments->comments = $request->comments;
            $grnPayments->created_at = Carbon::now();
            $grnPayments->updated_at = Carbon::now();
            $grnPayments->save();

            return redirect()->route('grn-payments')->with('success', 'GRN Payment Added Successfully');
        }
    }

    public function grnExport()
    {
        $grn = GoodReceiveNote::with('requistion.vendor')->with('grnPayments')->get();
        return view('purchase.goodreceivenote.export',
        [
            'grn' => $grn
        ]);
    }

    public function FormatunitRetail()
    {
        $batchPOS = BatchPOS::all();
        foreach($batchPOS as $batch){
            $unitretail = $batch->unit_retail;
            $unitretail = number_format($unitretail, 2);
            $unitretail = removeCommaFromNumbers($unitretail);
            BatchPOS::where('id', $batch->id)->update([
                'unit_retail' => $unitretail,
            ]);
        }
    }

    public function FinanceReport()
    {
        return view('purchase.goodreceivenote.FinanceReport.index');
    }
}
