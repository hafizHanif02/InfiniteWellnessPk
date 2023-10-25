<?php

namespace App\Http\Controllers;

use DB;
use Exception;
use App\Models\Patient;
use Illuminate\View\View;
use App\Models\Appointment;
use App\Models\PatientCase;
use Illuminate\Http\Request;
use App\Models\DoctorOpdCharge;
use Illuminate\Http\JsonResponse;
use App\Exports\AppointmentExport;
use Illuminate\Routing\Redirector;
use App\Models\OpdPatientDepartment;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\AppointmentRepository;
use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
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

    /**
     * Store a newly created appointment in storage.
     *
     * @return JsonResponse
     */
    public function store(CreateAppointmentRequest $request)
    {
        $input = $request->all();
        //return $this->sendSuccess($input['patient_id']);

        $input['opd_date'] = $input['opd_date'].$input['time'];
        $input['is_completed'] = isset($input['status']) ? Appointment::STATUS_COMPLETED : Appointment::STATUS_PENDING;
        if ($request->user()->hasRole('Patient')) {
            $input['patient_id'] = $request->user()->owner_id;
        }
        $this->appointmentRepository->create($input);
        $this->appointmentRepository->createNotification($input);
        
        //$case_id = PatientCase::where('patient_id',$input['patient_id'])->pluck('id');
        $caseID = PatientCase::where('patient_id', $input['patient_id'])->orderBy('id', 'desc')->first();

        $standard_charge = DoctorOpdCharge::where('doctor_id', $input['doctor_id'])->first();
        
        OpdPatientDepartment::create([
            'patient_id' =>  $input['patient_id'],
            'opd_number' => OpdPatientDepartment::generateUniqueOpdNumber(),
            'appointment_date' => $input['opd_date'],
            'case_id' => $caseID->id,
            'doctor_id' => $input['doctor_id'],
            'standard_charge' => $standard_charge->standard_charge,
            'payment_mode' => 1,
            'currency_symbol' => 'pkr'
        ]);
        //-------------------------------------
        /*
        $patientData = DB::table('patients')->where(['id'=>$input['patient_id']])->get();
        $user = DB::table('users')->where(['owner_id' => $patientData[0]->id])->where('owner_type', 'LIKE', '%Patient%')->get();

        $recipient = $user[0]->email;
        $subject = 'Appointment Created';
        $data = [
            'message' => 'Your Appointment has been created for Dr. this this on '.$input['opd_date'].' time 00:00 AM.',
        ];

        Mail::send('emails.email', $data, function ($message) use ($recipient, $subject) {
            $message->to($recipient)
                ->subject($subject);
        });*/

        return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.saved_successfully'));
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

            return $this->sendSuccess(__('messages.common.status_updated_successfully'));
        }
    }

    public function cancelAppointment(Appointment $appointment): JsonResponse
    {
        if ((getLoggedinPatient() && $appointment->patient_id != getLoggedInUser()->owner_id) || (getLoggedinDoctor() && $appointment->doctor_id != getLoggedInUser()->owner_id)) {
            return $this->sendError(__('messages.web_menu.appointment').' '.__('messages.common.not_found'));
        } else {
            $appointment->update(['is_completed' => Appointment::STATUS_CANCELLED]);

            return $this->sendSuccess(__('messages.web_menu.appointment').' '.__('messages.common.canceled'));
        }
    }
}
