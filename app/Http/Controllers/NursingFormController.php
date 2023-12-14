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
use App\Models\FastMedicalRecord;
use Illuminate\Support\Facades\Validator;

class NursingFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('nursing_form.index', [
            'nursing_froms' => NursingForm::with('patient.user')->latest()->paginate(10),
        ]);
    }


    public function opd(Request $request)
    {

        $getPatientID = Patient::where(['MR' => $request->patient_mr_number])->get();

        if (count($getPatientID) > 0) {
            return response()->json([
                'data' => OpdPatientDepartment::where('patient_id', $getPatientID[0]->id)->with('patient.user', 'doctor.user')->get(),
                'data2' => DentalOpdPatientDepartment::where('patient_id', $getPatientID[0]->id)->with('patient.user')->get(),
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
        return view('nursing_form.create', [
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
        // dd($request);
        Patient::where('id', $request->patient_id)->update([
            'blood_pressure' => $request->blood_pressure,
            'heart_rate' => $request->heart_rate,
            'respiratory_rate' => $request->respiratory_rate,
            'temperature' => $request->temperature,
            'height' => $request->height,
            'weight' => $request->weight,
            'bmi' => $request->bmi,
        ]);

        $nursingfrom = NursingForm::create($request->validated());
        foreach ($request->medications as $medication) {
            Medication::create([
                'nursing_form_id' => $nursingfrom->id,
                'patient_mr_number' => $request->patient_mr_number,
                'medication_name' => $medication['medication_name'],
                'dosage' => $medication['dosage'],
                'frequency' => $medication['frequency'],
                'prescribing_physician' => $medication['prescribing_physician'],
            ]);
        }

        foreach ($request->allergies as $allergie) {
            Allergies::create([
                'nursing_form_id' => $nursingfrom->id,
                'patient_mr_number' => $request->patient_mr_number,
                'allergen' => $allergie['allergen'],
                'reaction' => $allergie['reaction'],
                'severity' => $allergie['severity'],
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

        return to_route('nursing.index')->with('success', 'Nurse Form created!');
    }


    public function showForm(Request $request)
    {
        $nurForm = NursingForm::where('id', $request->formID)->first();

        return view('nursing_form.show', [
            'patients' => Patient::with('user')->where('MR', $nurForm->patient_mr_number)->first(),
            'nursing' => $nurForm,
            'medication' => Medication::where('nursing_form_id', $request->formID)->get(),
            'allergies' => Allergies::where('nursing_form_id', $request->formID)->get(),
        ]);
    }

    public function getFormData(Request $request)
    {
        $mrNum = Patient::where('id', $request->mrNumber)->first();
        $nurForm = NursingForm::where('patient_mr_number', $mrNum->MR)->latest()->first();

        if ($nurForm) {
            return [
                'patients' => Patient::with('user')->where('MR', $nurForm->patient_mr_number)->first(),
                'nursing' => $nurForm,
                'medication' => Medication::where('nursing_form_id', $nurForm->id)->get(),
                'allergies' => Allergies::where('nursing_form_id', $nurForm->id)->get(),
            ];
        }
        return 0;
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

    public function fastMedicalRecord()
    {
        return view('Fast-Medical-Record.index', [
            'fast_medical_records' => FastMedicalRecord::get(),
        ]);
    }
    public function fastMedicalRecordcreate()
    {
        return view('Fast-Medical-Record.create', [
            'patients' => Patient::with('user')->get(),
        ]);
    }

    public function fastMedicalRecordstore(Request $request)
    {
        $validator = Validator::make($request->all(), ([
            'patient_name' => 'required',
            'referred_by' => 'required',
            'dob' => 'required',
            'contact' => 'required',
            'referrel_date' => 'required',
            'pre_test_date' => 'required',
            'pre_test_status' => 'required',
            'blood_collection_date' => 'required',
            'blood_collection_amount' => 'required',
            'blood_collection_status' => 'required',
            'date_of_shipment' => 'required',
            'fast_test_report_date' => 'required',
            'fast_test_report_status' => 'required',
            'report_session_date' => 'required',
            'report_session_status' => 'required',
            'post_test_consult_date' => 'required',
            'post_test_consult_status' => 'required',
            'post_post_test_date' => 'required',
            'post_post_test_status' => 'required',
            'retest_date' => 'required',
            'retest_date_status' => 'required',
            'dietitian' => 'required',
            'comment' => 'required',
        ]));

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            FastMedicalRecord::create($request->all());
            return to_route('fast-medical-record.index')->with('success', 'Fast Medical Record created!');
        }
    }

    public function fastMedicalRecordShow($id)
    {
        return view('Fast-Medical-Record.show', [
            'Fast_Medical_Record' => FastMedicalRecord::where('id', $id)->first(),
        ]);
    }
    
    public function fastMedicalRecordPrint()
    {
        return view('Fast-Medical-Record.print', [
            'Fast_Medical_Record' => FastMedicalRecord::get(),
        ]);
    }

}
