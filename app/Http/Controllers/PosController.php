<?php

namespace App\Http\Controllers;

use Barcode;
use Carbon\Carbon;
use App\Models\Log;
use App\Models\Pos;
use App\Models\Patient;
use App\Models\BatchPOS;
use App\Models\Medicine;
use App\Models\PosReturn;
use Illuminate\View\View;
use App\Exports\PosExport;
use Laracasts\Flash\Flash;
use App\Models\Pos_Product;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\PosProductReturn;
use App\Http\Requests\PosRequest;
use App\Models\Inventory\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\ProductQuantityInRange;
use Illuminate\Http\RedirectResponse;
use Picqer\Barcode\BarcodeGeneratorHTML;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PosController extends Controller
{
    public function index(): View
    {
        return view('pos.index', [
            'poses' => Pos::latest()->with(['prescription.getMedicine', 'prescription.doctor', 'prescription.patient'])->paginate(10),
        ]);
    }

    public function create(): View
    {
        $prescriptions = Prescription::latest()->with(['getMedicine.medicine', 'doctor.user', 'patient.user'])->get();
        $medicines = Medicine::with('product','batchpos.batch')->get();
        $patients = Patient::with('user')->get();
        $pos_id = Pos::latest()->pluck('id')->first();
        return view('pos.create', [
            'prescriptions' => $prescriptions,
            'medicines' => $medicines,
            'patients' => $patients,
            'pos_id' => $pos_id
        ]);
    }
    public function validatePos(Request $request){
        $customMessages = [
            'products.*.medicine_id.required' => 'At least one product is required',
            'products.*.product_quantity.required' => 'At least one product quantity is required',
            'products.*.product_quantity.numeric' => 'Product quantity must be a numeric value',
            'products.*.product_quantity.min' => 'Product quantity must be at least one',
        ];



        $validatedData = $request->validate([
            'patient_name' => ['required', 'string'],
            'patient_number' => ['nullable', 'string'],
            'total_amount' => ['required', 'numeric'],
            'pos_fees' => ['required', 'numeric'],
            'products' => 'required|array',
            'products.*.medicine_id' => 'required|exists:medicines,id',
            'products.*.product_quantity' => ['required', 'numeric', new ProductQuantityInRange],
            'total_discount'=> ['nullable','numeric'],
            'total_saletax'=> ['nullable','numeric'],
            'total_amount_ex_saletax'=> ['nullable','numeric'],
            'total_amount_inc_saletax'=> ['nullable','numeric'],
            'patient_mr_number' => ['nullable', 'string'],
            'doctor_name' => ['nullable', 'string'],
            'cashier_name' => ['nullable', 'string'],
            'pos_date' => ['required', 'date'],
            'enter_payment_amount' => ['nullable', 'numeric'],
            'change_amount' => ['nullable', 'numeric'],
        ], $customMessages);

            // Validation succeeded
            return response()->json(['valid' => true, 'message' => 'Validation succeeded.']);


    }

    public function store(PosRequest $request)
    {  
        //fbr work start
            $pos_id =  $request->pos_id;
            $patient_name = $request->patient_name;
            $pos_date =  $request->pos_date;
            $patient_number = $request->patient_number;
            $total_amount = $request->total_amount;
            $total_saletax = $request->total_saletax;
            $total_salevalue = $request->total_amount_inc_saletax;
              $allItems = [];
              $totalQty = 0;
              $gstAmount = 0;
                 if (!empty($request->products) && is_array($request->products)) {
                     foreach ($request->products as $product) {
                     
                        $item = [
                            "ItemCode" => $product['medicine_id'] ,
                            "ItemName" => $product['product_name'] ,
                            "Quantity" => $product['product_quantity'] ,
                            "PCTCode" => "11001010",
                            "TaxRate" => "0.00" ,
                            "SaleValue" => $product['mrp_perunit'] ,
                            "TotalAmount" => $product['product_total_price'] ,
                            "TaxCharged" => $product['gst_amount'] ,
                            "Discount" => $product['discount_amount'] ,
                            "FurtherTax" => 0.0,
                            "InvoiceType" => 1,
                            "RefUSIN" => null
                        ];
                        $totalQty += $product['product_quantity'];
                        $gstAmount += floatval($product['gst_amount']);
                        $allItems[] = $item;
                    
                }
            }  
        $datafbr = [
            "InvoiceNumber" => $request->pos_id,
            "POSID" => 161992,
            "USIN" => "USIN0",
            "DateTime" => $pos_date,
            "BuyerNTN" => "1234567-8",
            "BuyerCNIC" => "12345-1234567-8",
            "BuyerName" => $patient_name,
            "BuyerPhoneNumber" => $patient_number,
            "items" => $allItems,
            "TotalBillAmount" => $total_amount,
            "TotalQuantity" => $totalQty,
            "TotalSaleValue" => $total_salevalue,
            "TotalTaxCharged" => $gstAmount,
            "PaymentMode" => 2,
            "InvoiceType" => 1,
        ];
        
        $curl = curl_init();
        $datafbr_json = json_encode($datafbr);
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>$datafbr_json,
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer 455391dc-76c1-3c2e-a0bc-2d33ccf6b655',
            'Content-Type: application/json'
        ),
        ));
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_message = curl_error($curl);
            echo "Curl Error: " . $error_message;
        } else {
            $dataRes = json_decode($response);

            if ($dataRes && isset($dataRes->InvoiceNumber)) {
                $invoiceNumber = $dataRes->InvoiceNumber;   
                $userId = auth()->user()->id; 
                $posData = array_merge($request->validated(), [
                    'user_id' => $userId,
                    'fbr_invoice_no' => $invoiceNumber 
                ]);
                $pos = Pos::create($posData);
            
            } else {
              
                Flash::message('Fbr Invoice Not Created!');
            }
        }       
        curl_close($curl);
        // fbr work end
        // exit;
        $userId = auth()->user()->id;

        $request->validate([
            'products' => 'required|array',
            'products.*.medicine_id' => 'required|exists:medicines,id',
        ]);

        // Create POS and associated products
        // $pos = Pos::create(array_merge($request->validated(), ['user_id' => $userId]));

        $user = Auth::user();
        $requistionproductlogs = 'Pos No.'.$pos->id.' Products:{[medicine_id, qty],';
        foreach ($request->input('products') as $productData) {
           $pos_product = Pos_Product::create(array_merge($productData, ['pos_id' => $pos->id, 'user_id' => $userId]));
            // Medicine::where('product_id', $productData->product_id)->decrement(
            //     'total_quantity', $transferProduct->total_piece);
            $requistionproductlogs .= '['.$pos_product->medicine_id.','.$pos_product->product_quantity.'],';
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Pos Has Been Created Pos No.'.$pos->id ,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'log/' . $logs->id . '.txt';
        $filePath = public_path($fileName);
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);
        Flash::message('POS created!');

        return redirect()->route('pos.proceed-to-pay-page', ['pos' => $pos]);
    }

    public function ProceedToPayPage($pos)
    {
        $pos = Pos::where('id', $pos)->with(['PosProduct.medicine', 'prescription.patient', 'prescription.getMedicine.medicine', 'prescription.doctor.doctorUser', 'prescription.patient.patientUser'])->first();
        $user = Auth::user();
        // Log::create([
        //     'action' => 'POS Proceede To Checkout Pos No.'.$pos->id ,
        //     'action_by_user_id' => $user->id,
        // ]);
        return view('pos.proceed_to_pay', [
            'pos' => $pos,
        ]);
    }

    public function EnterPayMethod($pos)
    {

        $posData = Pos::where('id', $pos)->with(['PosProduct'])->first();
        return view('pos.paymet', [
            'pos' => $posData,
        ]);
    }


    public function Payment(Request $reqeust, $pos)
    {
        $Pos_Product = Pos_Product::where('pos_id', $pos)->with('batchpos')->get();

        $pos_id = $pos;

        $pos = Pos::where('id', $pos)->update([
            'is_cash' => $reqeust->is_cash,
            'is_paid' => 1,
            'enter_payment_amount' => $reqeust->enter_payment_amount,
            'change_amount' => $reqeust->change_amount,

        ]);



        foreach ($Pos_Product as $PosProduct) {
            Medicine::where('id', $PosProduct->medicine_id)->decrementEach([
                'total_quantity' => $PosProduct->product_quantity
            ]);
            BatchPOS::where('id', $PosProduct->batchpos->id)->incrementEach([
                'sold_quantity' => $PosProduct->product_quantity,
            ]);
            BatchPOS::where('id', $PosProduct->batchpos->id)->update([
                'remaining_qty' => $PosProduct->batchpos->remaining_qty - $PosProduct->product_quantity
            ]);
        }


        $user = Auth::user();
        Log::create([
            'action' => 'POS Payement Enter Pos No.'.$pos_id ,
            'action_by_user_id' => $user->id,
        ]);
        Flash::message('POS Payed!');

        return to_route('pos.print', $pos_id);
    }

    public function prescription(Request $request)
    {
        $getPatientID = Patient::where(['MR' => $request->patient_mr_number])->get();

        if (count($getPatientID) > 0) {
            return response()->json([
                'data' => Prescription::where('patient_id', $getPatientID[0]->id)->with('patient.user', 'getMedicine.medicine.product', 'getMedicine.medicine.batchpos.batch', 'doctor.user')->get(),
            ]);
        }


        return response()->json([
            'data' => ''
        ]);
    }
    public function Print($pos)
    {
        $posData = Pos::where('id', $pos)->with(['PosProduct.medicine.brand'])->first();
        $generatorHTML = new BarcodeGeneratorHTML();
        if ($posData->patient_mr_number != null) {
            $mr_barcode = $generatorHTML->getBarcode($posData->patient_mr_number, $generatorHTML::TYPE_CODE_128);
        } else {
            $mr_barcode = null;
        }
        $invoice_barcode = $generatorHTML->getBarcode($posData->id, $generatorHTML::TYPE_CODE_128);
        
        if($posData->fbr_invoice_no != null){
            $invoiceNo = $posData->fbr_invoice_no;
            $qrCode = QrCode::size(70)->generate($invoiceNo);
        }else{
            $qrCode = '';
        }
        return view('pos.print', [
            'pos' => $posData,
            'mr_barcode' => $mr_barcode,
            'invoice_barcode' => $invoice_barcode,
            'qrCode' => $qrCode
        ]);
    }




    public function show($id)
    {
        $pos = Pos::where('id', $id)->with(['PosProduct.medicine', 'prescription.patient', 'prescription.getMedicine.medicine', 'prescription.doctor.doctorUser', 'prescription.patient.patientUser'])->first();

        return view('pos.show', [
            'pos' => $pos,
        ]);
    }

    public function edit($id)
    {
        $PosId = Pos::where('id',$id)->exists();
        if(!$PosId){
            Flash::error('POS Not Found!');
            return to_route('pos.index');
        }
        return view('pos.edit', [
            'pos' => Pos::where('id',$id)->with(['PosProduct.medicine.product'])->first(),
            'pos_products' => Pos_Product::where('pos_id', $id)->with('label','batchpos.batch')->get(),
            'medicines' => Medicine::with(['product', 'batchpos.batch'])->get(),
            'patients' => Patient::with('user')->get(),
            'prescriptions' => Prescription::latest()->with(['getMedicine.medicine', 'doctor.user', 'patient.user'])->get(),
        ]);
    }



    public function update(PosRequest $request, $id)
    {
        // dd($request);
        $pos = Pos::find($id)->update($request->all());
        Pos_Product::where('pos_id', $id)->delete();
        $user = Auth::user();
        $requistionproductlogs = 'Pos No. '.$request->pos_id.' Products:{[medicine_id, qty],';
        foreach ($request->input('products') as $productData) {
            Pos_Product::create(array_merge($productData, ['pos_id' => $id]));
            $requistionproductlogs .= '['.$productData['medicine_id'].','.$productData['product_quantity'].'],';
        }
        $requistionproductlogs .= '}';
        $logs = Log::create([
            'action' => 'Pos Has Been Updated Pos No.'.$request->pos_id ,
            'action_by_user_id' => $user->id,
        ]);
        $fileName = 'log/' . $logs->id . '.txt';
        $filePath = public_path($fileName);
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        file_put_contents($filePath, $requistionproductlogs);
        Flash::message('POS Updated!');
        return to_route('pos.proceed-to-pay-page', $id);
        // return redirect()->route('pos.index');
    }

    public function destroy($id)
    {
        $pos = Pos::find($id)->delete();
        $user = Auth::user();
        Log::create([
            'action' => 'Pos Has Been Deleted Pos No.'.$id ,
            'action_by_user_id' => $user->id,
        ]);
        Flash::message('POS Deleted!');

        return to_route('pos.index');
    }




    public function posfilterlistindex(Request $request)
    {

        return view('pos.filter-list', [
            'pos' => Pos::filter($request)->get(),
            'paid_pos' => Pos::where('is_paid',1)->get(),
        ]);
    }
    public function posfilterlistajax(Request $request): JsonResponse
    {

        return response()->json([
            'data' => Pos::filter($request)->latest()->get(),
        ]);
    }

    public function posreturnfilterlistdata(Request $request)
    {

        return view('pos-return.filter-list', [
            'pos' => PosReturn::with('pos')->filter($request)->latest()->paginate(10)->onEachSide(1),
        ]);
    }
    public function posfilterlistdata(Request $request): JsonResponse
    {

        return response()->json([
            // 'data' => PosReturn::with('pos')->whereHas('pos', function ($query) {$query->where('is_cash', 1);})->latest()->get(),
            'data' => PosReturn::with('pos')->filter($request)->latest()->get(),
        ]);
    }
    public function posdailyreport(Request $request)
    {
        $posData = Pos::filter($request)->where('is_paid',1)->latest()->paginate(10)->onEachSide(1);
        $posReturnData = PosReturn::with('pos')->filter($request)->latest()->paginate(10)->onEachSide(1);

        return view('pos-return.daily-report', [
            'pos' => Pos::filter($request)->where('is_paid',1)->latest()->get(),
            'posreturns' => PosReturn::with('pos')->filter($request)->latest()->get(),
        ]);
    }



    public function printReport()
    {
        return Excel::download(new PosExport, 'Pos-Report.xlsx');
    }


    // ITEM REPORT
    public function itemReport(Request $request)
    {
        $medicines = Medicine::with('product.manufacturer')->get();

        foreach ($medicines as $medicine) {

            $sell_qty = Pos_Product::where('medicine_id', $medicine->id)
                ->where('pos.is_paid', 1)
                ->leftJoin('pos', 'pos.id', '=', 'pos__products.pos_id')
                ->when($request->date_from && $request->date_to, function ($query) use ($request) {
                    $dateTo = Carbon::parse($request->date_to)->addDay()->toDateString();
                    $query->whereBetween('pos__products.created_at', [$request->date_from, Carbon::parse($request->date_to)->addDay()->toDateString()]);
                })
                ->when($request->date_from, function ($query) use ($request) {
                    $query->where('pos__products.created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($query) use ($request) {
                    $query->where('pos__products.created_at', '<=', Carbon::parse($request->date_to)->addDay()->toDateString());
                })
                ->sum('product_quantity');

            $return_qty = PosProductReturn::where('medicine_id', $medicine->id)
                ->where('pos.is_paid', 1)
                ->leftJoin('pos', 'pos.id', '=', 'pos_product_returns.pos_id')
                ->when($request->date_from && $request->date_to, function ($query) use ($request) {
                    $query->whereBetween('pos_product_returns.created_at', [$request->date_from, Carbon::parse($request->date_to)->addDay()->toDateString()]);
                })
                ->when($request->date_from, function ($query) use ($request) {
                    $query->where('pos_product_returns.created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($query) use ($request) {
                    $query->where('pos_product_returns.created_at', '<=', Carbon::parse($request->date_to)->addDay()->toDateString());
                })
                ->sum('product_quantity');

            $medicine->sell_qty = $sell_qty;
            $medicine->return_qty = $return_qty;
        }

        return view('item-report.itemreport', [
            'medicines' => $medicines,
        ]);
    }



    public function itemReportPrint(Request $request)
    {
        $medicines = Medicine::with('product.manufacturer')->get();

        foreach ($medicines as $medicine) {

            $sell_qty = Pos_Product::where('medicine_id', $medicine->id)
                ->where('pos.is_paid', 1)
                ->leftJoin('pos', 'pos.id', '=', 'pos__products.pos_id')
                ->when($request->date_from && $request->date_to, function ($query) use ($request) {
                    $dateTo = Carbon::parse($request->date_to)->addDay()->toDateString();
                    $query->whereBetween('pos__products.created_at', [$request->date_from, Carbon::parse($request->date_to)->addDay()->toDateString()]);
                })
                ->when($request->date_from, function ($query) use ($request) {
                    $query->where('pos__products.created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($query) use ($request) {
                    $query->where('pos__products.created_at', '<=', Carbon::parse($request->date_to)->addDay()->toDateString());
                })
                ->sum('product_quantity');

            $return_qty = PosProductReturn::where('medicine_id', $medicine->id)
                ->where('pos.is_paid', 1)
                ->leftJoin('pos', 'pos.id', '=', 'pos_product_returns.pos_id')
                ->when($request->date_from && $request->date_to, function ($query) use ($request) {
                    $query->whereBetween('pos_product_returns.created_at', [$request->date_from, Carbon::parse($request->date_to)->addDay()->toDateString()]);
                })
                ->when($request->date_from, function ($query) use ($request) {
                    $query->where('pos_product_returns.created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($query) use ($request) {
                    $query->where('pos_product_returns.created_at', '<=', Carbon::parse($request->date_to)->addDay()->toDateString());
                })
                ->sum('product_quantity');

            $medicine->sell_qty = $sell_qty;
            $medicine->return_qty = $return_qty;
        }

        return view('item-report.print', [
            'medicines' => $medicines,
        ]);
    }

    public function recalculate($id)
    {
        $user = Auth::user();
        $posProducts = Pos_Product::where('pos_id', $id)->get();
        // dd($posProducts);
        foreach($posProducts as $posProduct){
            $price = $posProduct->product_quantity * $posProduct->mrp_perunit;
            $discount = $posProduct->discount_amount;
            $product_total_price = $price - $discount;

            $posProduct->update([
                'product_total_price' => $product_total_price
            ]);
            $discount = $posProducts->sum('discount_amount');
            // $total_saletax = Pos::;
            $total_amount_inc_saletax = $posProducts->sum('product_total_price');
            $total_amount_ex_saletax = $posProducts->sum('product_total_price');
            // $total_amount_ex_saletax = $total_amount_ex_saletax + $total_saletax;
            $total_amount = $total_amount_inc_saletax + 1;
        }
        $pos = Pos::where('id', $id)->first();
        $total_saletax = $pos->total_saletax;
        Pos::where('id', $id)->update([
            'total_discount' => $discount,
            'total_amount_inc_saletax' => $total_amount_inc_saletax,
            'total_amount_ex_saletax' => $total_amount_inc_saletax - $total_saletax,
            'total_amount' => $total_amount,
            'total_saletax' => $total_saletax
        ]);
        $logs = Log::create([
            'action' => 'Pos Has Been Recalculated Pos No.'.$pos->id,
            'action_by_user_id' => $user->id,
        ]);
        Flash::message('Recalculated Successfully!');
        return redirect()->back();

    }
    public function exportToExcel()
    {
    $pos = Pos_Product::with('pos.PosProductReturn')->get();
        // dd($pos[167]);
        return view('pos.exportpos', [
            'pos' => $pos,
        ]);
    }

    public function profitLossPOS()
    {
        $posProducts = Pos_Product::with('medicine')->get();

        foreach($posProducts as $product){
            $product->date = $product->created_at->format('Y-m-d');
            $product->cost_per_unit = Product::where('id', $product->medicine->product_id)->first()->trade_price;
        }
        return view('pos.profit-loss', compact('posProducts'));
    }
}
