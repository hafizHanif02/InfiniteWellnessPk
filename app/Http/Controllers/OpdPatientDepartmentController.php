<?php

namespace App\Http\Controllers;

use Flash;
use Exception;
use App\Models\User;
use App\Models\Charge;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\View\View;
use App\Mail\MarkdownMail;
use App\Models\Appointment;
use App\Models\Receptionist;
use Illuminate\Http\Request;
use App\Models\ChargeCategory;
use App\Models\DoctorOpdCharge;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Models\OpdPatientDepartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail as Email;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Response;
use App\Models\DentalOpdPatientDepartment;
use App\Http\Controllers\AppBaseController;
use App\Repositories\OpdPatientDepartmentRepository;
use App\Http\Requests\CreateOpdPatientDepartmentRequest;
use App\Http\Requests\UpdateOpdPatientDepartmentRequest;

/**
 * Class OpdPatientDepartmentController
 */
class OpdPatientDepartmentController extends AppBaseController
{
    /** @var OpdPatientDepartmentRepository */
    private $opdPatientDepartmentRepository;

    public function __construct(OpdPatientDepartmentRepository $opdPatientDepartmentRepo)
    {
        $this->opdPatientDepartmentRepository = $opdPatientDepartmentRepo;
    }

    /**
     * Display a listing of the OpdPatientDepartment.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        return view('opd_patient_departments.index');
    }

    public function dentalIndex(){
        return view('dentalOpd_patient_departments.index');
    }

    public function create(Request $request)
    {
        $data = $this->opdPatientDepartmentRepository->getAssociatedData();
        $data['revisit'] = ($request->get('revisit')) ? $request->get('revisit') : 0;
        if ($data['revisit']) {
            $id = $data['revisit'];
            $data['last_visit'] = OpdPatientDepartment::findOrFail($id);
        }

        foreach ($data['patients2'] as $key => $value) {
            $data['patients'][$value->id] = $value->MR. " - ".$value->patientUser->full_name;
        }

        return view('opd_patient_departments.create', compact('data'));
    }

    public function dentalCreate(Request $request){
        $data = $this->opdPatientDepartmentRepository->getAssociatedData();
        $data['revisit'] = ($request->get('revisit')) ? $request->get('revisit') : 0;
        if ($data['revisit']) {
            $id = $data['revisit'];
            $data['last_visit'] = DentalOpdPatientDepartment::findOrFail($id);
        }

        foreach ($data['patients2'] as $key => $value) {
            $data['patients'][$value->id] = $value->MR. " - ".$value->patientUser->full_name;
        }


        $chargeCate = ChargeCategory::where('charge_type', 6)->get();

        foreach ($chargeCate as $key => $value) {
            $chargeCate[$key]->allCharges = Charge::where('charge_category_id', $value->id)->get();
        }


        return view('dentalOpd_patient_departments.create', compact('data', 'chargeCate'));
    }
    public function getOpdData(Request $request){
        $data = OpdPatientDepartment::where(['patient_id'=>$request->pataientID])->get()->toArray();
        $data2 = DentalOpdPatientDepartment::where(['patient_id'=>$request->pataientID])->get()->toArray();
        $newData = array_merge($data,$data2);

        return $newData;
    }

    public function getOpdDataDocName(Request $request){
        $data = OpdPatientDepartment::where(['opd_number'=>$request->opdNumber])->with('doctor')->get();
        if(count($data) > 0){
            return Doctor::where('id',$data[0]->doctor->id)->with('doctorUser')->first();
        }else {
            return ['doctor_user'=> ['full_name' =>'no Doctor']];
        }

        return User::where('id',$data->doctor->doctor_user_id)->first();
    }

    /**
     * Store a newly created OpdPatientDepartment in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateOpdPatientDepartmentRequest $request)
    {
        $input = $request->all();
        $doc = Doctor::where('id', $request->doctor_id)->first();
        $receptions = Receptionist::with('user')->get();


        if(!empty($input['standard_charge'])) {
            $input['standard_charge'] = removeCommaFromNumbers($input['standard_charge']);
        }
        if(!empty($input['followup_charge'])) {
            $input['followup_charge'] = removeCommaFromNumbers($input['followup_charge']);
        }
        // $input['standard_charge'] = removeCommaFromNumbers($input['standard_charge']);
        // $input['followup_charge'] = removeCommaFromNumbers($input['followup_charge']);
        $patiendID = $this->opdPatientDepartmentRepository->store($input);
        $this->opdPatientDepartmentRepository->createNotification($input);
        Flash::success(__('messages.opd_patient.opd_patient').' '.__('messages.common.saved_successfully'));


        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'doctor_department_id' => $doc->department_id,
            'opd_date' => $request->appointment_date,
        ]);

        // Email
        $patient = Patient::where('id',  $request->patient_id)->with('user')->first();
        $doctor = Doctor::where('id',  $request->doctor_id)->with('user')->first();
        $receptions = Receptionist::with('user')->get();
        $recipient = [
        ($patient->user->email != null) ? $patient->user->email : '',
            $doctor->user->email,
        ];
        $subject = 'OPD Created';
        $data = array(
            'message' => 'OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
        );


        $mail = array(
            'to' => $recipient,
            'subject' => $subject,
            'message' => 'OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
            'attachments' => null,
        );
        
        Email::to($recipient)
            ->send(new MarkdownMail('emails.email',
                $mail['subject'], $mail));

                foreach($receptions as $reception){

                    $reception_mail = $reception->user->email;
                    $reception_array = [];
                    $reception_array[] = $reception_mail;
        
        
                    $mail = array(
                        'to' => $reception_array,
                        'subject' => $subject,
                        'message' => 'OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
                        'attachments' => null,
                    );
        
                    Email::to($reception_array)
                    ->send(new MarkdownMail('emails.email',
                        $mail['subject'], $mail));
                }
        // Email

        return redirect(route('opd.patient.index'));
    }

    public function dentalStore(Request $request){
        $input = $request->all();
        
        // dd($input);
        $data = [
            "currency_symbol" => $request->currency_symbol,
            "patient_id" => $request->patient_id,
            "doctor_id" => $request->doctor_id,
            "case_id" => $request->case_id,
            "opd_number" => $request->opd_number,
            "height" => $request->height,
            "weight"=> $request->weight,
            "bp" => $request->bp,
            "doctor_id" => $request->doctor_id,
            "appointment_date" => $request->appointment_date,
            "payment_mode" => $request->payment_mode,
            "symptoms"=> $request->symptoms,
            "notes" => $request->notes,
            "service_id" => $request->chargesList,
            "standard_charge" => $request->standard_charge,
            "followup_charge" => $request->followup_charge,
            "total_amount" => $request->total_amount,
        ];
        DentalOpdPatientDepartment::insert($data);

        $doc = Doctor::where('id', $request->doctor_id)->first();
        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'doctor_department_id' => $doc->department_id,
            'opd_date' => $request->appointment_date,
        ]);

         $patient = Patient::where('id',  $request->patient_id)->with('user')->first();
        $doctor = Doctor::where('id',  $request->doctor_id)->with('user')->first();
        $receptions = Receptionist::with('user')->get();
        $recipient = [
        ($patient->user->email != null) ? $patient->user->email : '',
            $doctor->user->email,
        ];
        $subject = 'Dental OPD Created';
        $data = array(
            'message' => 'Dental OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
        );


        $mail = array(
            'to' => $recipient,
            'subject' => $subject,
            'message' => 'Dental OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
            'attachments' => null,
        );
        
        Email::to($recipient)
            ->send(new MarkdownMail('emails.email',
                $mail['subject'], $mail));

                foreach($receptions as $reception){

                    $reception_mail = $reception->user->email;
                    $reception_array = [];
                    $reception_array[] = $reception_mail;
        
        
                    $mail = array(
                        'to' => $reception_array,
                        'subject' => $subject,
                        'message' => 'OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
                        'attachments' => null,
                    );
        
                    Email::to($reception_array)
                    ->send(new MarkdownMail('emails.email',
                        $mail['subject'], $mail));
                }


        Flash::success(('Dentel OPD Created Successfully'));
        return redirect(route('dentalopd.patient.index'));
    }

    public function opdPrint(Request $request){
        $doctors = $this->opdPatientDepartmentRepository->getDoctorsData();
        $opdPatientDepartment = OpdPatientDepartment::where('id', $request->opdID)->first();
        //        $doctorsList = $this->opdPatientDepartmentRepository->getDoctorsList();
        return view('opd_patient_departments.print', compact('opdPatientDepartment', 'doctors'));
        return $request->opdID;
    }

    public function dentalOpdPrint(Request $request){

        $opdPatientDepartment = DentalOpdPatientDepartment::where('id', $request->opdID)->first();
        //        $doctorsList = $this->opdPatientDepartmentRepository->getDoctorsList();
        return view('dentalOpd_patient_departments.print', compact('opdPatientDepartment'));
        return $request->opdID;
    }
    /**
     * Display the specified OpdPatientDepartment.
     *
     * @return Factory|View
     */
    public function show(OpdPatientDepartment $opdPatientDepartment)
    {
        $doctors = $this->opdPatientDepartmentRepository->getDoctorsData();

        //        $doctorsList = $this->opdPatientDepartmentRepository->getDoctorsList();
        return view('opd_patient_departments.show', compact('opdPatientDepartment', 'doctors'));
    }

    public function showdental(DentalOpdPatientDepartment $opdPatientDepartment)
    {
        $doctor = $opdPatientDepartment->doctor;

        //        $doctorsList = $this->opdPatientDepartmentRepository->getDoctorsList();
        return view('opd_patient_departments.showdental', compact('opdPatientDepartment'));
    }

    /**
     * Show the form for editing the specified Ipd Diagnosis.
     *
     * @return Factory|View
     */
    public function edit(OpdPatientDepartment $opdPatientDepartment)
    {
        $patientData = $opdPatientDepartment->patient->user;
        // dd($patientData);
        $data = $this->opdPatientDepartmentRepository->getAssociatedData();

        return view('opd_patient_departments.edit', compact('data', 'opdPatientDepartment','patientData'));
    }

    /**
     * Update the specified Ipd Diagnosis in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function update(OpdPatientDepartment $opdPatientDepartment, UpdateOpdPatientDepartmentRequest $request)
    {
        $input = $request->all();
        if(!empty($input['standard_charge'])) {
            $input['standard_charge'] = removeCommaFromNumbers($input['standard_charge']);
        }
        if(!empty($input['followup_charge'])) {
            $input['followup_charge'] = removeCommaFromNumbers($input['followup_charge']);
        }
        $this->opdPatientDepartmentRepository->updateOpdPatientDepartment($input, $opdPatientDepartment);
        Flash::success(__('messages.opd_patient.opd_patient').' '.__('messages.common.updated_successfully'));

        return redirect(route('opd.patient.index'));
    }

    /**
     * Remove the specified OpdPatientDepartment from storage.
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $opdPatientDepartment = OpdPatientDepartment::findOrFail($id);
        $opdPatientDepartment->delete();

        return $this->sendSuccess(__('messages.opd_patient.opd_patient').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @return JsonResponse
     */
    public function getPatientCasesList(Request $request)
    {
        $patientCases = $this->opdPatientDepartmentRepository->getPatientCases($request->get('id'));

        return $this->sendResponse($patientCases, 'Retrieved successfully');
    }

    /**
     * @return JsonResponse
     */
    public function getDoctorOPDCharge(Request $request)
    {
        $doctorOPDCharge = DoctorOpdCharge::whereDoctorId($request->get('id'))->with('doctor')->get();

        return $this->sendResponse($doctorOPDCharge, 'Doctor OPD Charge retrieved successfully.');
    }
    public function dentalDelete(Request $request)
    {
        $opdPatientDepartment = DentalOpdPatientDepartment::where('id', $request->id)->first();

        $opdPatientDepartment->delete();

        Flash::success(('Dentel OPD Deleted Successfully'));

        return redirect(route('dentalopd.patient.index'));
        
        
    }


    public function adddiagnosis(Request $request){
        DB::table('dental_opd_diagnoses')->insert([
            'opd_patient_department_id' => $request->opd_patient_department_id,
            'report_type' => $request->report_type,
            'report_date' => $request->report_date,
            'description' => $request->description,
        ]);
        // Flash::success(('Diagnosis Added Successfully'));
        // return redirect(route('dentalopd.patient.index'));

    }

    public function addtimelines(Request $request){
        DB::table('dental_opd_timelines')->insert([
            'opd_patient_department_id' => $request->opd_patient_department_id,
            'title' => $request->title,
            'date' => $request->date,
            'description' => $request->description,
            'visible_to_person' => $request->visible_to_person,
        ]);
        $javascript = '<script>location.reload();</script>';
        // Flash::success(('Timelines Added Successfully'));
        // return Response::make($javascript);
        // return redirect(route('dentalopd.patient.index'));

    }
}
