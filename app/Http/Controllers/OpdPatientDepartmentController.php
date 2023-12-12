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

    public function dentalOpdEdit( $dentalOpdPatientDepartment , Request $request){
        
        $dentalOpdPatientDepartment = DentalOpdPatientDepartment::findOrFail($dentalOpdPatientDepartment);
        //return $dentalOpdPatientDepartment;
        
        //dd();
        $data = $this->opdPatientDepartmentRepository->getAssociatedData();
        $data['revisit'] = ($request->get('revisit')) ? $request->get('revisit') : 0;
        if ($data['revisit']) {
            $id = $data['revisit'];
            $data['last_visit'] = DentalOpdPatientDepartment::findOrFail($id);
        }

        foreach ($data['patients2'] as $key => $value) {
            $data['patients'][$value->id] = $value->MR. " - ".$value->patientUser->full_name;
        }

        // dd($dentalOpdPatientDepartment);

        $chargeCate = ChargeCategory::where('charge_type', 6)->get();

        foreach ($chargeCate as $key => $value) {
            $chargeCate[$key]->allCharges = Charge::where('charge_category_id', $value->id)->get();
        }

        return view('dentalOpd_patient_departments.edit', compact('data','dentalOpdPatientDepartment','chargeCate'));

    }

    public function dentalOpdUpdate($dentalOpdPatientDepartment , Request $request)
    {
        $dentalOpdPatientDepartment = DentalOpdPatientDepartment::findOrFail($dentalOpdPatientDepartment);

        $appointment_id = Appointment::where('id', $dentalOpdPatientDepartment->appointment_id)->first();
        $patient = Patient::where('id', $dentalOpdPatientDepartment->patient_id)->first();

        $followup_charge = DoctorOpdCharge::where('doctor_id', $dentalOpdPatientDepartment->doctor_id)->first();
        $standard_charge = DoctorOpdCharge::where('doctor_id', $dentalOpdPatientDepartment->doctor_id)->first();

        if($request->standard_charge){
            $dentalOpdPatientDepartment->update([
                'patient_id' =>  $request->patient_id,
                'appointment_id' => $appointment_id->id,
                'doctor_id' => $request->doctor_id,
                'opd_number' => DentalOpdPatientDepartment::generateUniqueOpdNumber(),
                'case_id' => $request->patient_case_id,
                'height' => $patient->height?$patient->height:'',
                'weight' => $patient->weight?$patient->weight:'',
                'bp' => $patient->blood_pressure?$patient->blood_pressure:'',
                'appointment_date' => $request->opd_date,
                'standard_charge' => $standard_charge->standard_charge,
                'followup_charge' => 0,
                'total_amount' => $request->total_amount,
                'payment_mode' => $request->payment_mode,
                'currency_symbol' => 'pkr',
                'symptoms'=> $request->symptoms,
                'notes'=> $request->notes,
                'service_id' => $request->chargesList
            ]);
        }
        if($request->followup_charge){
            $dentalOpdPatientDepartment->update([
                'patient_id' =>  $request->patient_id,
                'appointment_id' => $appointment_id->id,
                'doctor_id' => $request->doctor_id,
                'opd_number' => DentalOpdPatientDepartment::generateUniqueOpdNumber(),
                'case_id' => $request->patient_case_id,
                'height' => $patient->height?$patient->height:'',
                'weight' => $patient->weight?$patient->weight:'',
                'bp' => $patient->blood_pressure?$patient->blood_pressure:'',
                'appointment_date' => $request->opd_date,
                'standard_charge' => 0,
                'followup_charge' => $followup_charge->followup_charge,
                'total_amount' => $request->total_amount,
                'payment_mode' => $request->payment_mode,
                'currency_symbol' => 'pkr',
                'symptoms'=> $request->symptoms,
                'notes'=> $request->notes,
                'service_id' => $request->chargesList
            ]);
        }
        $doctor_department = Doctor::where('id', $dentalOpdPatientDepartment->doctor_id)->first();
        Appointment::where('id', $dentalOpdPatientDepartment->appointment_id)->update([
            'doctor_id' => $dentalOpdPatientDepartment->doctor_id,
            'doctor_department_id' => $doctor_department->department_id,
            'opd_date' => $request->appointment_date,
        ]);

        // Email
        // $patient = Patient::where('id',  $dentalOpdPatientDepartment->patient_id)->with('user')->first();
        // $doctor = Doctor::where('id',  $dentalOpdPatientDepartment->doctor_id)->with('user')->first();
        // $receptions = Receptionist::with('user')->get();

        // $patientEmail = $patient->user->email;
        // $doctorEmail = $doctor->user->email;

        // $recipient = [
        // $patientEmail,
        // $doctorEmail
        // ];

        // $subject = 'Dental OPD ' . $dentalOpdPatientDepartment->opd_number .'  Updated';
        // if (!empty($patientEmail)) {
        //     // $message = 'OPD And Appointment has been updated of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$input['appointment_date'].' Date & Time ';
        //     $message = 'Dental OPD And Appointment  has been Updated of '. $doctor->user->full_name .' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ';

        //     $recipient = [$patientEmail, $doctorEmail];
        //     $mail = [
        //         'to' => $recipient,
        //         'subject' => $subject,
        //         'message' => $message,
        //         'attachments' => null,
        //     ];
        
        //     Email::to($recipient)
        //         ->send(new MarkdownMail('emails.email', $mail['subject'], $mail));
        // }else{
        //     $message = 'Dental OPD And Appointment  has been Updated of '. $doctor->user->full_name .' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ';

        //     $recipient = $doctorEmail;
        //     $mail = [
        //         'to' => $recipient,
        //         'subject' => $subject,
        //         'message' => $message,
        //         'attachments' => null,
        //     ];
        
        //     Email::to($recipient)
        //         ->send(new MarkdownMail('emails.email', $mail['subject'], $mail));
        // }

        //         foreach($receptions as $reception){

        //             $reception_mail = $reception->user->email;
        //             $reception_array = [];
        //             $reception_array[] = $reception_mail;
        
        
        //             $mail = array(
        //                 'to' => $reception_array,
        //                 'subject' => $subject,
        //                 $message = 'Dental OPD And Appointment  has been Updated of '. $doctor->user->full_name .' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
        //                 'attachments' => null,
        //             );
        
        //             Email::to($reception_array)
        //             ->send(new MarkdownMail('emails.email',
        //                 $mail['subject'], $mail));
        //         }
        // Email





        $patient = Patient::where('id',  $request->patient_id)->with('user')->first();
        $doctor = Doctor::where('id',  $request->doctor_id)->with('user')->first();
        $receptions = Receptionist::with('user')->get();

        $patientEmail = $patient->user->email;
        $doctorEmail = $doctor->user->email;
        $recipient = [
        // ($patient->user->email != null) ? $patient->user->email : '',
        //     $doctor->user->email,
        $patientEmail,
        $doctorEmail
        ];

        $subject = 'Dental OPD Created';
        if(!empty($patientEmail)){
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
        }
        else{
            $data = array(
                'message' => 'Dental OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
            );
            $recipient = $doctorEmail;
            $mail = array(
                'to' => $recipient,
                'subject' => $subject,
                'message' => 'Dental OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
                'attachments' => null,
            );

            Email::to($recipient)
                ->send(new MarkdownMail('emails.email',
                    $mail['subject'], $mail));
        }
                foreach($receptions as $reception){

                    $reception_mail = $reception->user->email;
                    $reception_array = [];
                    $reception_array[] = $reception_mail;
        
        
                    $mail = array(
                        'to' => $reception_array,
                        'subject' => $subject,
                        'message' => 'Dental OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
                        'attachments' => null,
                    );
        
                    Email::to($reception_array)
                    ->send(new MarkdownMail('emails.email',
                        $mail['subject'], $mail));
                }
        

        return redirect(route('dentalopd.patient.index'));
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

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'doctor_department_id' => $doc->department_id,
            'opd_date' => $request->appointment_date,
        ]);

        if(!empty($input['standard_charge'])) {
            $input['standard_charge'] = removeCommaFromNumbers($input['standard_charge']);
        }
        if(!empty($input['followup_charge'])) {
            $input['followup_charge'] = removeCommaFromNumbers($input['followup_charge']);
        }
        // $input['standard_charge'] = removeCommaFromNumbers($input['standard_charge']);
        // $input['followup_charge'] = removeCommaFromNumbers($input['followup_charge']);
        $input['appointment_id'] = $appointment->id;
        $patiendID = $this->opdPatientDepartmentRepository->store($input);
        $this->opdPatientDepartmentRepository->createNotification($input);
        Flash::success(__('messages.opd_patient.opd_patient').' '.__('messages.common.saved_successfully'));

        // Email
        $patient = Patient::where('id',  $request->patient_id)->with('user')->first();
        $doctor = Doctor::where('id',  $request->doctor_id)->with('user')->first();
        $receptions = Receptionist::with('user')->get();

        $patientEmail = $patient->user->email;
        $doctorEmail = $doctor->user->email;

        $recipient = [
        // ($patient->user->email != null) ? $patient->user->email : '',
        //     $doctor->user->email,
        $patientEmail,
        $doctorEmail
        ];

        $subject = 'OPD Created';
        if (!empty($patientEmail)) {
            $message = 'OPD And Appointment has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ';

            $recipient = [$patientEmail, $doctorEmail];
            $mail = [
                'to' => $recipient,
                'subject' => $subject,
                'message' => $message,
                'attachments' => null,
            ];
        
            Email::to($recipient)
                ->send(new MarkdownMail('emails.email', $mail['subject'], $mail));
        }else{
            $message = 'OPD And Appointment has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ';

            $recipient = $doctorEmail;
            $mail = [
                'to' => $recipient,
                'subject' => $subject,
                'message' => $message,
                'attachments' => null,
            ];
        
            Email::to($recipient)
                ->send(new MarkdownMail('emails.email', $mail['subject'], $mail));
        }

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
        $doc = Doctor::where('id', $request->doctor_id)->first();

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'doctor_department_id' => $doc->department_id,
            'opd_date' => $request->appointment_date,
        ]);
        
        // dd($input);
        $data = [
            "currency_symbol" => $request->currency_symbol,
            "patient_id" => $request->patient_id,
            'appointment_id' => $appointment->id,
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

        

         $patient = Patient::where('id',  $request->patient_id)->with('user')->first();
        $doctor = Doctor::where('id',  $request->doctor_id)->with('user')->first();
        $receptions = Receptionist::with('user')->get();

        $patientEmail = $patient->user->email;
        $doctorEmail = $doctor->user->email;
        $recipient = [
        // ($patient->user->email != null) ? $patient->user->email : '',
        //     $doctor->user->email,
        $patientEmail,
        $doctorEmail
        ];

        $subject = 'Dental OPD Created';
        if(!empty($patientEmail)){
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
        }
        else{
            $data = array(
                'message' => 'Dental OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
            );
            $recipient = $doctorEmail;
            $mail = array(
                'to' => $recipient,
                'subject' => $subject,
                'message' => 'Dental OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
                'attachments' => null,
            );

            Email::to($recipient)
                ->send(new MarkdownMail('emails.email',
                    $mail['subject'], $mail));
        }
                foreach($receptions as $reception){

                    $reception_mail = $reception->user->email;
                    $reception_array = [];
                    $reception_array[] = $reception_mail;
        
        
                    $mail = array(
                        'to' => $reception_array,
                        'subject' => $subject,
                        'message' => 'Dental OPD And Appointment  has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$request->appointment_date.' Date & Time ',
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

        $doc = Doctor::where('id', $input['doctor_id'])->first();
        $receptions = Receptionist::with('user')->get();

        // $this->opdPatientDepartmentRepository->updateOpdPatientDepartment($input, $opdPatientDepartment);
        if(!empty($input['standard_charge'])) {

            OPDPatientDepartment::where('id', $opdPatientDepartment->id)->update([
                'patient_id' => $input['patient_id'],
                'doctor_id' => $input['doctor_id'],
                'case_id' => $input['case_id'],
                'opd_number' => $input['opd_number'],
                'height' => $input['height'],
                'weight' => $input['weight'],
                'bp' => $input['bp'],
                'symptoms' => $input['symptoms'],
                'notes' => $input['notes'],
                'appointment_date' => $input['appointment_date'],
                'is_old_patient' => 0,
                'standard_charge' => $input['standard_charge'],
                'followup_charge' => 0,
                'payment_mode' => $input['payment_mode'],
                'currency_symbol' => 'PKR',
            ]);

        }else{
            OPDPatientDepartment::where('id', $opdPatientDepartment->id)->update([
                'patient_id' => $input['patient_id'],
                'doctor_id' => $input['doctor_id'],
                'case_id' => $input['case_id'],
                'opd_number' => $input['opd_number'],
                'height' => $input['height'],
                'weight' => $input['weight'],
                'bp' => $input['bp'],
                'symptoms' => $input['symptoms'],
                'notes' => $input['notes'],
                'appointment_date' => $input['appointment_date'],
                'is_old_patient' => 1,
                'standard_charge' => 0,
                'followup_charge' => $input['followup_charge'],
                'payment_mode' => $input['payment_mode'],
                'currency_symbol' => 'PKR',
            ]);
        }

        $doctor_department = Doctor::where('id', $input['doctor_id'])->first();
        Appointment::where('id', $input['appointment_id'])->update([
            'doctor_id' => $input['doctor_id'],
            'doctor_department_id' => $doctor_department->department_id,
            'opd_date' => $input['appointment_date'],
        ]);


        // Email
        $patient = Patient::where('id',  $input['patient_id'])->with('user')->first();
        $doctor = Doctor::where('id',  $input['doctor_id'])->with('user')->first();
        $receptions = Receptionist::with('user')->get();

        $patientEmail = $patient->user->email;
        $doctorEmail = $doctor->user->email;

        $recipient = [
        // ($patient->user->email != null) ? $patient->user->email : '',
        //     $doctor->user->email,
        $patientEmail,
        $doctorEmail
        ];

        $subject = 'OPD ' .$input['opd_number'] .'  Updated';
        if (!empty($patientEmail)) {
            $message = 'OPD And Appointment has been updated of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$input['appointment_date'].' Date & Time ';

            $recipient = [$patientEmail, $doctorEmail];
            $mail = [
                'to' => $recipient,
                'subject' => $subject,
                'message' => $message,
                'attachments' => null,
            ];
        
            Email::to($recipient)
                ->send(new MarkdownMail('emails.email', $mail['subject'], $mail));
        }else{
            $message = 'OPD And Appointment has been updated of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$input['appointment_date'].' Date & Time ';

            $recipient = $doctorEmail;
            $mail = [
                'to' => $recipient,
                'subject' => $subject,
                'message' => $message,
                'attachments' => null,
            ];
        
            Email::to($recipient)
                ->send(new MarkdownMail('emails.email', $mail['subject'], $mail));
        }

                foreach($receptions as $reception){

                    $reception_mail = $reception->user->email;
                    $reception_array = [];
                    $reception_array[] = $reception_mail;
        
        
                    $mail = array(
                        'to' => $reception_array,
                        'subject' => $subject,
                        $message = 'OPD And Appointment has been updated of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$input['appointment_date'].' Date & Time ',
                        'attachments' => null,
                    );
        
                    Email::to($reception_array)
                    ->send(new MarkdownMail('emails.email',
                        $mail['subject'], $mail));
                }
        // Email

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
