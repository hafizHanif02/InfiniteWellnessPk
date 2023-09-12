<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use App\Models\Prescription;
use Illuminate\Http\Request;
use App\Http\Requests\PosRequest;
use App\Models\Pos_Product;
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
        ]);
    }

    public function store(PosRequest $request): RedirectResponse
    {
        $pos = Pos::create($request->validated());
        foreach($request->products as $product){
            dd($product);
            Pos_Product::create([
                'pos_id' => $request->id,
                'product_id' => $products['product_id'],
                'product_name' => $products['product_name'],
                'product_quantity' => $products['product_quantity'],
                'product_total_price' => $products['product_total_price'],
            ]);
        }
        Flash::message('POS created!');

        return to_route('pos.proceed-to-pay-page', $pos);
    }

    public function ProceedToPayPage($pos)
    {
        $pos = Pos::where('id', $pos)->with(['prescription.patient', 'prescription.getMedicine.medicine', 'prescription.doctor.doctorUser', 'prescription.patient.patientUser'])->first();

        return view('pos.proceed_to_pay', [
            'pos' => $pos,
        ]);
    }

    public function ProceedToPay($pos, $requst)
    {
        Pos::where('id', $pos)->update([
            'is_paid' => 1,
            'given_amount' => $request->given_amount,
            'change_amount' => $request->change_amount,

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
