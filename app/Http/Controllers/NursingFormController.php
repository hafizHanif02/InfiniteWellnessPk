<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Allergies;
use App\Models\Medication;
use App\Models\NursingForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OpdPatientDepartment;
use App\Http\Requests\NursingFormRequest;
use App\Models\DentalOpdPatientDepartment;

class NursingFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('nursing_form.index',[
            'nursing_froms' => NursingForm::latest()->paginate(10),
        ]);
    }


    public function opd(Request $request)
    {

        $getPatientID = Patient::where(['MR'=> $request->patient_mr_number])->get();

        if(count($getPatientID) > 0){
            return response()->json([
                'data' => OpdPatientDepartment::where('patient_id',$getPatientID[0]->id)->with('patient.user','doctor.user')->get(),
                'data2' => DentalOpdPatientDepartment::where('patient_id',$getPatientID[0]->id)->with('patient.user')->get(),
            ]);
        }


        return response()->json([
            'data' => ''
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('nursing_form.create',[
            'patients' => Patient::with('user')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NursingFormRequest $request)
    {
        $nursingfrom = NursingForm::create($request->validated());
        foreach($request->medications as $medication){
            Medication::create([
                'nursing_form_id' => $nursingfrom->id,
                'patient_mr_number' => $request->patient_mr_number ,
                'medication_name' => $medication['medication_name'],
                'dosage'=> $medication['dosage'],
                'frequency' => $medication['frequency'],
                'prescribing_physician'=> $medication['prescribing_physician'],
            ]);
        }

        foreach($request->allergies as $allergie){
            Allergies::create([
                'nursing_form_id' => $nursingfrom->id,
                'patient_mr_number' => $request->patient_mr_number,
                'allergen' => $allergie['allergen'],
                'reaction'=> $allergie['reaction'],
                'severity'=> $allergie['severity'],
            ]);
        }
        // OpdPatientDepartment::where('opd_number',$request->opd_id)->update([
        //     'bp' => $request->blood_pressure,
        //     'height' => $request->height,
        //     'weight' => $request->weight,
        // ]);
        // DentalOpdPatientDepartment::where('opd_number',$request->opd_id)->update([
        //     'bp' => $request->blood_pressure,
        //     'height' => $request->height,
        //     'weight' => $request->weight,
        // ]);

        return to_route('nursing-form.index')->with('success', 'Nurse Form created!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NursingForm  $nursingForm
     * @return \Illuminate\Http\Response
     */
    public function show(NursingForm $nursingForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NursingForm  $nursingForm
     * @return \Illuminate\Http\Response
     */
    public function edit(NursingForm $nursingForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NursingForm  $nursingForm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NursingForm $nursingForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NursingForm  $nursingForm
     * @return \Illuminate\Http\Response
     */
    public function destroy(NursingForm $nursingForm)
    {
        $nursingForm->delete();
        return to_route('nursing-form.index')->with('success', 'Nurse Form deleted!');
    }
}
