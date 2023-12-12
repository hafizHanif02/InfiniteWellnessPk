<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\View\View;
use App\Mail\MarkdownMail;
use App\Models\Appointment;
use App\Models\PatientCase;
use App\Models\Receptionist;
use Illuminate\Http\Request;
use App\Models\DoctorOpdCharge;
use Illuminate\Http\JsonResponse;
use App\Exports\AppointmentExport;
use Illuminate\Routing\Redirector;
use App\Models\OpdPatientDepartment;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\AppointmentRepository;
use Illuminate\Support\Facades\Mail as Email;
use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\DentalOpdPatientDepartment;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


/**
 * Class AppointmentController
 */
class AppointmentController extends AppBaseController
{
    /** @var AppointmentRepository */
    private $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepo)
    {
        $this->appointmentRepository = $appointmentRepo;
    }

    /**
     * Display a listing of the appointment.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        $statusArr = Appointment::STATUS_ARR;

        return view('appointments.index', compact('statusArr'));
    }

    /**
     * Show the form for creating a new appointment.
     *
     * @return Factory|View
     */
    public function create()
    {
        $patients = $this->appointmentRepository->getPatients();
        $departments = $this->appointmentRepository->getDoctorDepartments();
        $statusArr = Appointment::STATUS_PENDING;

        return view('appointments.create', compact('patients', 'departments', 'statusArr'));
    }

    public function getPatientCase(Request $request)
    {
        $patient_id = $request->get('patient_id');
        $patientCase = PatientCase::where('patient_id', $patient_id)->get();
        return response()->json($patientCase);
    }

    /**
     * Store a newly created appointment in storage.
     *
     * @return JsonResponse
     */
    public function store(CreateAppointmentRequest $request)
    {
        $input = $request->all();
        //return $this->sendSuccess($input['patient_id']);

        $patient = Patient::where('id', $input['patient_id'])->with('user')->first();

        $input['opd_date'] = $input['opd_date'].$input['time'];
        // $input['is_completed'] = isset($input['status']) ? Appointment::STATUS_COMPLETED : Appointment::STATUS_PENDING;
        $input['is_completed'] = 0;
        if ($request->user()->hasRole('Patient')) {
            $input['patient_id'] = $request->user()->owner_id;
        }
        $this->appointmentRepository->create($input);
        $appoint_id = DB::getPdo()->lastInsertId();
        $this->appointmentRepository->createNotification($input);
        
        //$case_id = PatientCase::where('patient_id',$input['patient_id'])->pluck('id');
        $caseID = PatientCase::where('patient_id', $input['patient_id'])->orderBy('id', 'desc')->first();

        $standard_charge = DoctorOpdCharge::where('doctor_id', $input['doctor_id'])->first();
        $followup_charge = DoctorOpdCharge::where('doctor_id', $input['doctor_id'])->first();

        if($request->doctor_department_id == 5){
            if($request->patient_case_id != null){
                DentalOpdPatientDepartment::create([
                    'patient_id' =>  $input['patient_id'],
                    'appointment_id' => $appoint_id,
                    'doctor_id' => $input['doctor_id'],
                    'opd_number' => DentalOpdPatientDepartment::generateUniqueOpdNumber(),
                    'case_id' => $input['patient_case_id'],
                    'height' => $patient->height?$patient->height:'',
                    'weight' => $patient->weight?$patient->weight:'',
                    'bp' => $patient->blood_pressure?$patient->blood_pressure:'',
                    'appointment_date' => $input['opd_date'],
                    'followup_charge' => $followup_charge->followup_charge,
                    'advance_amount' => $input['advance_amount'],
                    'total_amount' => $followup_charge->followup_charge,
                    'payment_mode' => $input['payment_mode'],
                    'currency_symbol' => 'pkr'
                ]);
            }else{
                DentalOpdPatientDepartment::create([
                    'patient_id' =>  $input['patient_id'],
                    'appointment_id' => $appoint_id,
                    'doctor_id' => $input['doctor_id'],
                    'opd_number' => DentalOpdPatientDepartment::generateUniqueOpdNumber(),
                    'case_id' => $caseID->id,
                    'height' => $patient->height?$patient->height:'',
                    'weight' => $patient->weight?$patient->weight:'',
                    'bp' => $patient->blood_pressure?$patient->blood_pressure:'',
                    'appointment_date' => $input['opd_date'],
                    'standard_charge' => $standard_charge->standard_charge,
                    'total_amount' => $standard_charge->standard_charge,
                    'advance_amount' => $input['advance_amount'],
                    'payment_mode' => $input['payment_mode'],
                    'currency_symbol' => 'pkr'
                ]);
            }
        }else{
            if($request->patient_case_id != null){
                OpdPatientDepartment::create([
                    'patient_id' =>  $input['patient_id'],
                    'opd_number' => OpdPatientDepartment::generateUniqueOpdNumber(),
                    'appointment_date' => $input['opd_date'],
                    'case_id' => $input['patient_case_id'],
                    'appointment_id' => $appoint_id,
                    'doctor_id' => $input['doctor_id'],
                    'followup_charge' => $followup_charge->followup_charge,
                    'advance_amount' => $input['advance_amount'],
                    'payment_mode' => $input['payment_mode'],
                    'currency_symbol' => 'pkr'
                ]);
            }else{
                OpdPatientDepartment::create([
                    'patient_id' =>  $input['patient_id'],
                    'opd_number' => OpdPatientDepartment::generateUniqueOpdNumber(),
                    'appointment_date' => $input['opd_date'],
                    'case_id' => $caseID->id,
                    'appointment_id' => $appoint_id,
                    'doctor_id' => $input['doctor_id'],
                    'standard_charge' => $standard_charge->standard_charge,
                    'advance_amount' => $input['advance_amount'],
                    'payment_mode' => $input['payment_mode'],
                    'currency_symbol' => 'pkr'
                ]);
            }
        }

        // $patient = Patient::where('id', $input['patient_id'])->with('user')->first();
        $doctor = Doctor::where('id', $input['doctor_id'])->with('user')->first();
        $receptions = Receptionist::with('user')->get();
        $patientEmail = $patient->user->email;
        $doctorEmail = $doctor->user->email;
        // $recipient = [$patient->user->email,$doctor->user->email];
        $recipient = [$patientEmail,$doctorEmail];

        $subject = 'Appointment Created';

        if(!empty($patientEmail)){
            $data = array(
                'message' => 'Appointment has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$input['opd_date'].' Date & Time ',
            );


            $mail = array(
                'to' => $recipient,
                'subject' => $subject,
                'message' => 'Appointment has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$input['opd_date'].' Date & Time ',
                'attachments' => null,
            );

            Email::to($recipient)
                ->send(new MarkdownMail('emails.email',
                    $mail['subject'], $mail));
        }else{
            $data = array(
                'message' => 'Appointment has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$input['opd_date'].' Date & Time ',
            );

            $recipient = $doctorEmail;
            $mail = array(
                'to' => $recipient,
                'subject' => $subject,
                'message' => 'Appointment has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$input['opd_date'].' Date & Time ',
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
                'message' => 'Appointment has been created of '.$doctor->user->full_name.' to Patient '.$patient->user->full_name.' on this '.$input['opd_date'].' Date & Time ',
                'attachments' => null,
            );

            Email::to($reception_array)
            ->send(new MarkdownMail('emails.email',
                $mail['subject'], $mail));
        }


        // Mail::send('emails.email', $data, function ($message) use ($recipient, $subject) {
        //     $message->to($recipient)
        //         ->subject($subject);
        // });

        return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.saved_successfully'));
    }

    public function sendmail(){
        
        
        // $patient = Patient::where('id', $input['patient_id'])->with('user')->first();
        $receptions = Receptionist::with('user')->get();

        $recipient = ['azeem.alikhan777@gmail.com','hafiz.hanif992@gmail.com' ];
        $subject = 'Appointment Created';
        $data = array(
            'message' => 'Your Appointment has been created',
        );


        // Mail::send('emails.email', $data, function ($mes) use ($recipient, $subject) {
        //     $mes->to($recipient)
        //         ->subject($subject);
               
        // });

        $mail = array(
            'to' => $recipient,
            'subject' => $subject,
            'message' =>'Your Appointment has been created',
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
                        'message' => 'Appointment has been created of Dr.  to Patient  on this  Date ',
                        'attachments' => null,
                    );
        
                    Email::to($reception_array)
                    ->send(new MarkdownMail('emails.email',
                        $mail['subject'], $mail));
                }

        
    }


    /**
     * Display the specified appointment.
     *
     * @return Factory|View|RedirectResponse
     */
    public function show(Appointment $appointment)
    {
        return view('appointments.show')->with('appointment', $appointment);
    }

    /**
     * Show the form for editing the specified appointment.
     *
     * @return RedirectResponse|Redirector|View
     */
    public function edit(Appointment $appointment)
    {
        $patients = $this->appointmentRepository->getPatients();
        $doctors = $this->appointmentRepository->getDoctors($appointment->department_id);
        $departments = $this->appointmentRepository->getDoctorDepartments();
        $statusArr = $appointment->is_completed;

        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'departments', 'statusArr'));
    }

    /**
     * Update the specified appointment in storage.
     *
     * @return JsonResponse
     */
    public function update(Appointment $appointment, UpdateAppointmentRequest $request)
    {
        $input = $request->all();
        $input['opd_date'] = $input['opd_date'].$input['time'];
        $input['is_completed'] = isset($input['status']) ? Appointment::STATUS_COMPLETED : Appointment::STATUS_PENDING;
        if ($request->user()->hasRole('Patient')) {
            $input['patient_id'] = $request->user()->owner_id;
        }
        $appointment = $this->appointmentRepository->update($input, $appointment->id);

        return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.updated_successfully'));
    }

    /**
     * Remove the specified appointment from storage.
     *
     *
     * @throws Exception
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        if (getLoggedinPatient() && $appointment->patient_id != getLoggedInUser()->owner_id) {
            return $this->sendError(__('messages.web_menu.appointment').' '.__('messages.common.not_found'));
        } else {
            $this->appointmentRepository->delete($appointment->id);

            return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.deleted_successfully'));
        }
    }

    /**
     * @return JsonResponse
     */
    public function getDoctors(Request $request)
    {
        $id = $request->get('id');

        $doctors = $this->appointmentRepository->getDoctors($id);

        return $this->sendResponse($doctors, 'Retrieved successfully');
    }

    /**
     * @return JsonResponse
     */
    public function getBookingSlot(Request $request)
    {
        $inputs = $request->all();
        $data = $this->appointmentRepository->getBookingSlot($inputs);

        return $this->sendResponse($data, 'Retrieved successfully');
    }

    /**
     * @return BinaryFileResponse
     */
    public function appointmentExport()
    {
        return Excel::download(new AppointmentExport, 'appointments-'.time().'.xlsx');
    }

    public function status(Appointment $appointment): JsonResponse
    {
        if (getLoggedinDoctor() && $appointment->doctor_id != getLoggedInUser()->owner_id) {
            return $this->sendError(__('messages.web_menu.appointment').' '.__('messages.common.not_found'));
        } else {
            $isCompleted = ! $appointment->is_completed;
            $appointment->update(['is_completed' => $isCompleted]);
            // EMAIL
            $patient = Patient::where('id', $appointment->patient_id)->with('user')->first();
            $doctor = Doctor::where('id',  $appointment->doctor_id)->with('user')->first();
            $receptions = Receptionist::with('user')->get();

            $patientEmail = $patient->user->email;
            $doctorEmail = $doctor->user->email;

            // $recipient = [$patient->user->email, $doctor->user->email];
            $recipient = [$patientEmail, $doctorEmail];
            $subject = 'Appointment Approved';

            if(!empty($patientEmail)){

                $data = array(
                    'message' => 'Appointment has been approved of ' . $doctor->user->full_name . ' to Patient ' . $patient->user->full_name . ' which is scheduled on ' . $appointment->opd_date . ' this Date & Time ',
                );


            $mail = array(
                'to' => $recipient,
                'subject' => $subject,
                'message' => 'Appointment has been approved of ' . $doctor->user->full_name . ' to Patient ' . $patient->user->full_name . ' which is scheduled on ' . $appointment->opd_date . ' this Date & Time ',
                'attachments' => null,
            );

            Email::to($recipient)
                ->send(new MarkdownMail(
                    'emails.email',
                    $mail['subject'],
                    $mail
                ));
            }else{
                $data = array(
                    'message' => 'Appointment has been approved of ' . $doctor->user->full_name . ' to Patient ' . $patient->user->full_name . ' which is scheduled on ' . $appointment->opd_date . ' this Date & Time ',
                );

                $recipient = $doctorEmail;
            $mail = array(
                'to' => $recipient,
                'subject' => $subject,
                'message' => 'Appointment has been approved of ' . $doctor->user->full_name . ' to Patient ' . $patient->user->full_name . ' which is scheduled on ' . $appointment->opd_date . ' this Date & Time ',
                'attachments' => null,
            );

            Email::to($recipient)
                ->send(new MarkdownMail(
                    'emails.email',
                    $mail['subject'],
                    $mail
                ));
            }

            foreach ($receptions as $reception) {

                $reception_mail = $reception->user->email;
                $reception_array = [];
                $reception_array[] = $reception_mail;


                $mail = array(
                    'to' => $reception_array,
                    'subject' => $subject,
                    'message' => 'Appointment has been approved of ' . $doctor->user->full_name . ' to Patient ' . $patient->user->full_name . ' which is scheduled on ' . $appointment->opd_date . ' this Date & Time ',
                    'attachments' => null,
                );

                Email::to($reception_array)
                    ->send(new MarkdownMail(
                        'emails.email',
                        $mail['subject'],
                        $mail
                    ));
            }
            // EMAIL
            return $this->sendSuccess(__('messages.common.status_updated_successfully'));
        }
    }

    public function cancelAppointment(Appointment $appointment): JsonResponse
    {
        if ((getLoggedinPatient() && $appointment->patient_id != getLoggedInUser()->owner_id) || (getLoggedinDoctor() && $appointment->doctor_id != getLoggedInUser()->owner_id)) {
            return $this->sendError(__('messages.web_menu.appointment').' '.__('messages.common.not_found'));
        } else {
            $appointment->update(['is_completed' => Appointment::STATUS_CANCELLED]);

            // EMAIL
            $patient = Patient::where('id', $appointment->patient_id)->with('user')->first();
            $doctor = Doctor::where('id',  $appointment->doctor_id)->with('user')->first();
            $receptions = Receptionist::with('user')->get();
            $patientEmail = $patient->user->email;
            $doctorEmail = $doctor->user->email;
            $recipient = [$patientEmail, $doctorEmail];
            // $recipient = [$patient->user->email, $doctor->user->email];
            $subject = 'Appointment Cancelled';

            if(!empty($patientEmail)){
                
                $data = array(
                    'message' => 'Appointment has been cancelled of ' . $doctor->user->full_name . ' to Patient ' . $patient->user->full_name . ' which is scheduled on ' . $appointment->opd_date . ' this Date & Time ',
                );
                
                
                $mail = array(
                'to' => $recipient,
                'subject' => $subject,
                'message' => 'Appointment has been cancelled of ' . $doctor->user->full_name . ' to Patient ' . $patient->user->full_name . ' which is scheduled on ' . $appointment->opd_date . ' this Date & Time ',
                'attachments' => null,
            );
            
            Email::to($recipient)
            ->send(new MarkdownMail(
                'emails.email',
                $mail['subject'],
                $mail
            ));
        }else{
            $data = array(
                'message' => 'Appointment has been cancelled of ' . $doctor->user->full_name . ' to Patient ' . $patient->user->full_name . ' which is scheduled on ' . $appointment->opd_date . ' this Date & Time ',
            );

            $recipient = $doctorEmail;
            
            $mail = array(
            'to' => $recipient,
            'subject' => $subject,
            'message' => 'Appointment has been cancelled of ' . $doctor->user->full_name . ' to Patient ' . $patient->user->full_name . ' which is scheduled on ' . $appointment->opd_date . ' this Date & Time ',
            'attachments' => null,
        );
        
        Email::to($recipient)
        ->send(new MarkdownMail(
            'emails.email',
            $mail['subject'],
            $mail
        ));
        }
            foreach ($receptions as $reception) {

                $reception_mail = $reception->user->email;
                $reception_array = [];
                $reception_array[] = $reception_mail;


                $mail = array(
                    'to' => $reception_array,
                    'subject' => $subject,
                    'message' => 'Appointment has been cancelled of ' . $doctor->user->full_name . ' to Patient ' . $patient->user->full_name . ' which is scheduled on ' . $appointment->opd_date . ' this Date & Time ',
                    'attachments' => null,
                );

                Email::to($reception_array)
                    ->send(new MarkdownMail(
                        'emails.email',
                        $mail['subject'],
                        $mail
                    ));
            }
            // EMAIL


            return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.canceled'));
        }
    }
}
