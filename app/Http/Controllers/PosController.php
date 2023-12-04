<?php

namespace App\Http\Controllers;

use Barcode;
use App\Models\Log;
use App\Models\Pos;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\PosReturn;
use Illuminate\View\View;
use App\Exports\PosExport;
use Laracasts\Flash\Flash;
use App\Models\Pos_Product;
use App\Models\BatchPOS;
use App\Rules\ProductQuantityInRange;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Models\PosProductReturn;
use App\Http\Requests\PosRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Carbon\Carbon;

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
        // dd(Medicine::with('product','batchpos.batch')->where('product_id',2407)->first());
        return view('pos.create', [
            'prescriptions' => Prescription::latest()->with(['getMedicine.medicine', 'doctor.user', 'patient.user'])->get(),
            'medicines' => Medicine::with('product','batchpos.batch')->get(),
            'patients' => Patient::with('user')->get(),
            'pos_id' => Pos::latest()->pluck('id')->first(),
        ]);
    }
    public function validatePos(Request $request){
        // foreach ($request->products as $product) {
        //     if ($product['total_stock'] < $product['product_quantity']) {
        //         return response()->json(['valid' => false, 'message' => 'Insufficient Stock']);
        //     }

        // }
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

    public function store(PosRequest $request): RedirectResponse
    {
        $userId = auth()->user()->id;

        $request->validate([
            'products' => 'required|array',
            'products.*.medicine_id' => 'required|exists:medicines,id',
        ]);

        // Create POS and associated products
        $pos = Pos::create(array_merge($request->validated(), ['user_id' => $userId]));

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

    // public function EnterMethod(Request $reqeust, $pos){

    //     $posData = Pos::where('id',$pos)->with('PosProduct')->first();

    //     if($reqeust->pay_method == 0){
    //         return view('pos.card-payment',[
    //             'pos' => $posData,
    //         ]);
    //     }else{
    //         return view('pos.cash-payment',[
    //             'pos' => $posData,
    //         ]);
    //     }
    // }


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
        return view('pos.print', [
            'pos' => $posData,
            'mr_barcode' => $mr_barcode,
            'invoice_barcode' => $invoice_barcode,
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
            'pos' => Pos::filter($request)->where('is_paid',1)->latest()->paginate(10)->onEachSide(1),
            'posreturns' => PosReturn::with('pos')->filter($request)->latest()->paginate(10)->onEachSide(1),
        ]);
    }



    public function printReport()
    {
        return Excel::download(new PosExport, 'Pos-Report.xlsx');
    }


    // POS ITEM REPORT

    // public function posItemReport(Request $request)
    // {
    //     $posid = Pos_Product::pluck('pos_id');

    //     // Query to calculate the total quantity and total price from returns
    //     $returnQuery = PosProductReturn::whereIn('pos_id', $posid)
    //         ->selectRaw('pos_id as pos_id, product_name as productName, SUM(product_quantity) as totalquantity, SUM(product_total_price) as totalprice')
    //         ->groupBy('medicine_id');

    //     // Query to calculate the total quantity from Pos_Product
    //     $posesQuery = Pos_Product::whereIn('pos_id', $posid)

    //         ->selectRaw('pos_id as pos_id, medicine_id, products.product_name as productName, SUM(product_quantity) as productQty')
    //         ->leftJoin('medicines', 'medicines.id', '=', 'pos__products.medicine_id')
    //         ->leftJoin('products', 'products.id', '=', 'medicines.product_id')
    //         ->leftJoin('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')
    //         ->selectRaw('medicines.*')
    //         ->selectRaw('manufacturers.*')
    //         ->groupBy('medicine_id');

    //     // Apply filters

    //     if ($request->date_from && $request->date_to) {
    //         $returnQuery->whereBetween('pos_product_returns.created_at', [$request->date_from, $request->date_to]);
    //         $posesQuery->whereBetween('pos__products.created_at', [$request->date_from, $request->date_to]);
    //     } elseif ($request->date_from) {
    //         $returnQuery->where('pos_product_returns.created_at', '>=', $request->date_from);
    //         $posesQuery->where('pos__products.created_at', '>=', $request->date_from);
    //     } elseif ($request->date_to) {
    //         $returnQuery->where('pos_product_returns.created_at', '<=', $request->date_to);
    //         $posesQuery->where('pos__products.created_at', '<=', $request->date_to);
    //     }

    //     // Fetch the data
    //     $posReturnQuantity = $returnQuery->get();
    //     $poses = $posesQuery->with('medicine')->get();
    //     $posReturns = PosProductReturn::whereIn('pos_id', $posid)->get();

    //     return view('item-report.index', [
    //         'poses' => $poses,
    //         'posReturns' => $posReturns,
    //         'posReturnQuantity' => $posReturnQuantity,
    //     ]);
    // }

    // public function posItemReportPrint(Request $request)
    // {
    //     $posid = Pos_Product::pluck('pos_id');

    //     // Query to calculate the total quantity and total price from returns
    //     $returnQuery = PosProductReturn::whereIn('pos_id', $posid)
    //         ->selectRaw('pos_id as pos_id, product_name as productName, SUM(product_quantity) as totalquantity, SUM(product_total_price) as totalprice')
    //         ->groupBy('medicine_id');

    //     // Query to calculate the total quantity from Pos_Product
    //     $posesQuery = Pos_Product::whereIn('pos_id', $posid)
    //     ->selectRaw('pos_id as pos_id, medicine_id, products.product_name as productName, SUM(product_quantity) as productQty')
    //     ->leftJoin('medicines', 'medicines.id', '=', 'pos__products.medicine_id')
    //     ->leftJoin('products', 'products.id', '=', 'medicines.product_id')
    //     ->leftJoin('manufacturers', 'manufacturers.id', '=', 'products.manufacturer_id')
    //     ->selectRaw('medicines.*')
    //     ->selectRaw('manufacturers.*')
    //     ->groupBy('medicine_id');

    //     // Apply filters

    //     if ($request->date_from && $request->date_to) {
    //         $returnQuery->whereBetween('pos_product_returns.created_at', [$request->date_from, $request->date_to]);
    //         $posesQuery->whereBetween('pos__products.created_at', [$request->date_from, $request->date_to]);
    //     } elseif ($request->date_from) {
    //         $returnQuery->where('pos_product_returns.created_at', '>=', $request->date_from);
    //         $posesQuery->where('pos__products.created_at', '>=', $request->date_from);
    //     } elseif ($request->date_to) {
    //         $returnQuery->where('pos_product_returns.created_at', '<=', $request->date_to);
    //         $posesQuery->where('pos__products.created_at', '<=', $request->date_to);
    //     }

    //     // Fetch the data
    //     $posReturnQuantity = $returnQuery->get();
    //     $poses = $posesQuery->get();
    //     $posReturns = PosProductReturn::whereIn('pos_id', $posid)->get();

    //     return view('item-report.print', [
    //         'poses' => $poses,
    //         'posReturns' => $posReturns,
    //         'posReturnQuantity' => $posReturnQuantity,
    //     ]);
    // }



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
                    $query->whereBetween('pos__products.created_at', [$request->date_from, $dateTo]);
                })
                ->when($request->date_from, function ($query) use ($request) {
                    $query->where('pos__products.created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($query) use ($request) {
                    $query->where('pos__products.created_at', '<=', $request->date_to);
                })
                ->sum('product_quantity');

            $return_qty = PosProductReturn::where('medicine_id', $medicine->id)
                ->where('pos.is_paid', 1)
                ->leftJoin('pos', 'pos.id', '=', 'pos_product_returns.pos_id')
                ->when($request->date_from && $request->date_to, function ($query) use ($request) {
                    $query->whereBetween('pos_product_returns.created_at', [$request->date_from, $request->date_to]);
                })
                ->when($request->date_from, function ($query) use ($request) {
                    $query->where('pos_product_returns.created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($query) use ($request) {
                    $query->where('pos_product_returns.created_at', '<=', $request->date_to);
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
                    $query->whereBetween('pos__products.created_at', [$request->date_from, $dateTo]);
                })
                ->when($request->date_from, function ($query) use ($request) {
                    $query->where('pos__products.created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($query) use ($request) {
                    $query->where('pos__products.created_at', '<=', $request->date_to);
                })
                ->sum('product_quantity');

            $return_qty = PosProductReturn::where('medicine_id', $medicine->id)
                ->where('pos.is_paid', 1)
                ->leftJoin('pos', 'pos.id', '=', 'pos_product_returns.pos_id')
                ->when($request->date_from && $request->date_to, function ($query) use ($request) {
                    $query->whereBetween('pos_product_returns.created_at', [$request->date_from, $request->date_to]);
                })
                ->when($request->date_from, function ($query) use ($request) {
                    $query->where('pos_product_returns.created_at', '>=', $request->date_from);
                })
                ->when($request->date_to, function ($query) use ($request) {
                    $query->where('pos_product_returns.created_at', '<=', $request->date_to);
                })
                ->sum('product_quantity');

            $medicine->sell_qty = $sell_qty;
            $medicine->return_qty = $return_qty;
        }

        return view('item-report.print', [
            'medicines' => $medicines,
        ]);
    }
}
