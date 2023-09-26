<?php

namespace App\Http\Controllers;

use Barcode;
use App\Models\Pos;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\PosReturn;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use App\Models\Pos_Product;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Requests\PosRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Picqer\Barcode\BarcodeGeneratorHTML;

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
        return view('pos.create', [
            'prescriptions' => Prescription::latest()->with(['getMedicine.medicine', 'doctor.user', 'patient.user'])->get(),
            'medicines' => Medicine::all(),
            'patients' => Patient::with('user')->get(),
            'pos_id' => Pos::latest()->pluck('id')->first(),
        ]);
    
    }

    public function store(PosRequest $request): RedirectResponse
    {
        $userId = auth()->user()->id;
        // echo $userId;
        //  exit; 

        $pos = Pos::create(array_merge($request->validated(), ['user_id' => $userId]));
    
        foreach ($request->products as $product) {
    
            Pos_Product::create([
                'pos_id' => $pos->id,
                'medicine_id' => $product['medicine_id'],
                'product_name' => $product['product_name'],
                'product_quantity' => $product['product_quantity'],
                'mrp_perunit' => $product['mrp_perunit'],
                'gst_percentage' => $product['gst_percentage'],
                'gst_amount' => $product['gst_amount'],
                'discount_percentage' => $product['discount_percentage'],
                'discount_amount' => $product['discount_amount'],
                'product_total_price' => $product['product_total_price'],
                'user_id' => $userId,
            ]);

            
        }
    
        Flash::message('POS created!');
    
        return to_route('pos.proceed-to-pay-page', $pos);
    }

    public function ProceedToPayPage($pos)
    {
        $pos = Pos::where('id', $pos)->with(['PosProduct.medicine','prescription.patient', 'prescription.getMedicine.medicine', 'prescription.doctor.doctorUser', 'prescription.patient.patientUser'])->first();

        return view('pos.proceed_to_pay', [
            'pos' => $pos,
        ]);
    }

    public function EnterPayMethod($pos)
    {

        $posData = Pos::where('id', $pos)->with(['PosProduct'])->first();
        return view('pos.paymet',[
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
        $Pos_Product = Pos_Product::where('pos_id',$pos)->get();


        Pos::where('id', $pos)->update([
            'is_cash' => $reqeust->is_cash,
            'is_paid' => 1,
            'enter_payment_amount' => $reqeust->enter_payment_amount,
            'change_amount' => $reqeust->change_amount,

        ]);

        foreach($Pos_Product as $PosProduct){
            Medicine::where('id',$PosProduct->medicine_id)->decrementEach([
                'total_quantity' => $PosProduct->product_quantity
            ]);
        }
        Flash::message('POS Payed!');

        return to_route('pos.print',$pos);
    }

    public function prescription(Request $request)
    {
        return response()->json([
            'data' => Prescription::where('patient_id',$request->paitent_id)->with('patient.user','getMedicine.medicine.brand','doctor.user')->get(),
        ]);
    }
    public function Print($pos){
        $posData = Pos::where('id', $pos)->with(['PosProduct.medicine.brand'])->first();
        $generatorHTML = new BarcodeGeneratorHTML();
        $barcode = $generatorHTML->getBarcode($posData->patient_mr_number, $generatorHTML::TYPE_CODE_128);
        return view('pos.print',[
            'pos' => $posData,
            'barcode' => $barcode,
        ]);
    }

    public function sample(){
        
        return view('pos.sample');
    }


    public function show($id)
    {
        $pos = Pos::where('id', $id)->with(['PosProduct.medicine','prescription.patient', 'prescription.getMedicine.medicine', 'prescription.doctor.doctorUser', 'prescription.patient.patientUser'])->first();

        return view('pos.show', [
            'pos' => $pos,
        ]);
    }

    public function edit($id)
    {
        //
    }

   

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Pos::find($id)->delete();
        Flash::message('POS Deleted!');

        return to_route('pos.index');
    }




    public function posfilterlistindex(Request $request)
    {
        
    return view('pos.filter-list', [
        'pos' => Pos::filter($request)->latest()->paginate(10)->onEachSide(1),
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

}
