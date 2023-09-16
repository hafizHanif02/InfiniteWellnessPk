<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use App\Models\Patient;
use App\Models\Medicine;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use App\Models\Pos_Product;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Requests\PosRequest;
use Illuminate\Http\RedirectResponse;

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
            'patients' => Patient::all(),
        ]);
    }

    public function store(PosRequest $request): RedirectResponse
    {
        $pos = Pos::create($request->validated());
        // dd($pos->id);
        foreach($request->products as $product){
            
            Pos_Product::create([
                'pos_id' => $pos->id,
                'medicine_id' => $product['medicine_id'],
                'product_name' => $product['product_name'],
                'product_quantity' => $product['product_quantity'],
                'product_total_price' => $product['product_total_price'],
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

    public function ProceedToPay(Request $reqeust, $pos)
    {
        // dd($reqeust);
        Pos::where('id', $pos)->update([
            'is_paid' => 1,
            'enter_payment_amount' => $reqeust->enter_payment_amount,
            'change_amount' => $reqeust->change_amount,

        ]);
        Flash::message('POS Payed!');

        return to_route('pos.index');
    }
    public function prescription(Request $request)
    {
        return response()->json([
            'data' => Prescription::where('patient_id',$request->paitent_id)->with('patient.user','getMedicine.medicine','doctor.user')->get(),
        ]);
    }

    public function show($id)
    {
        //
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
        //
    }
}
