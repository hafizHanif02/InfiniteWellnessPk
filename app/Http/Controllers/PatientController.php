<?php

namespace App\Http\Controllers;

use App;
use App\Exports\PatientExport;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\AdvancedPayment;
use App\Models\Appointment;
use App\Models\BedAssign;
use App\Models\Bill;
use App\Models\BirthReport;
use App\Models\DeathReport;
use App\Models\InvestigationReport;
use App\Models\Invoice;
use App\Models\IpdPatientDepartment;
use App\Models\OperationReport;
use App\Models\Patient;
use App\Models\PatientAdmission;
use App\Models\PatientCase;
use App\Models\Prescription;
use App\Models\Vaccination;
use App\Repositories\AdvancedPaymentRepository;
use App\Repositories\PatientRepository;
use DB;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Repositories\PatientCaseRepository;

class PatientController extends AppBaseController
{
    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepo)
    {
        $this->patientRepository = $patientRepo;
    }

    /**
     * Display a listing of the Patient.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        $data['statusArr'] = Patient::STATUS_ARR;

        return view('patients.index', $data);
    }

    /**
     * Show the form for creating a new Patient.
     *
     * @return Factory|View
     */
    public function create()
    {
        $bloodGroup = getBloodGroups();

        return view('patients.create', compact('bloodGroup'));
    }

    /**
     * Store a newly created Patient in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreatePatientRequest $request)
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;

        $userID = $this->patientRepository->store($input);
        $this->patientRepository->createNotification($input);
        $data = [
            "case_id" => mb_strtoupper(PatientCase::generateUniqueCaseId()),
            "currency_symbol" => "pkr",
            "patient_id" => $userID,
            "date" => now(),
            "phone" => null,
            "prefix_code" => "92",
            "status" => "1",
            "description" => null
        ];

            //---------------------

            $patientCase = PatientCase::create($data);

            //-------------------


        Flash::success(__('messages.advanced_payment.patient').' '.__('messages.common.saved_successfully'));

        return redirect(route('patients.index'));
    }


    public function storePatientCase($data)
    {
        $input = $data;

        $patientId = Patient::with('patientUser')->whereId($input['patient_id'])->first();
        $birthDate = $patientId->patientUser->dob;
        $caseDate = Carbon::parse($input['date'])->toDateString();
        // if (! empty($birthDate) && $caseDate < $birthDate) {
        //     Flash::error('Case date should not be smaller than patient birth date.');

        //     return redirect()->back()->withInput($input);
        // }


        $input['status'] = isset($input['status']) ? 1 : 0;
        $input['phone'] = preparePhoneNumber($input, 'phone');

        $this->patientCaseRepository->store($input);
        $this->patientCaseRepository->createNotification($input);

        // Flash::success(__('messages.case.case').' '.__('messages.common.saved_successfully'));

        // return redirect(route('patient-cases.index'));
    }

    /**
     * @param  int  $patientId
     * @return Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View
     */
    public function show($patientId)
    {
        $data = $this->patientRepository->getPatientAssociatedData($patientId);
        if (! $data) {
            return view('errors.404');
        }
        if (getLoggedinPatient() && checkRecordAccess($data->id)) {
            return view('errors.404');
        } else {
            $advancedPaymentRepo = App::make(AdvancedPaymentRepository::class);
            $patients = $advancedPaymentRepo->getPatients();
            $user = Auth::user();
            if ($user->hasRole('Doctor')) {
                $vaccinationPatients = getPatientsList($user->owner_id);
            } else {
                $vaccinationPatients = Patient::getActivePatientNames();
            }
            $vaccinations = Vaccination::toBase()->pluck('name', 'id')->toArray();
            natcasesort($vaccinations);

            $forms = DB::table('form_type')->get();
            $currentForm = DB::table('form_patient')->where(['patientID' => $patientId])->get();

            return view('patients.show', compact('data', 'patients', 'vaccinations', 'vaccinationPatients', 'forms', 'currentForm'));
        }
    }

    /**
     * Show the form for editing the specified Patient.
     *
     * @return Factory|View
     */
    public function edit(Patient $patient)
    {
        //        $user = $patient->patientUser;
        $bloodGroup = getBloodGroups();

        return view('patients.edit', compact('patient', 'bloodGroup'));
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function update(Patient $patient, UpdatePatientRequest $request)
    {
        if ($patient->is_default == 1) {
            Flash::error('This action is not allowed for default record.');

            return redirect(route('patients.index'));
        }

        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;
        $this->patientRepository->update($input, $patient);

        Flash::success(__('messages.advanced_payment.patient').' '.__('messages.common.updated_successfully'));

        return redirect(route('patients.index'));
    }

    /**
     * Remove the specified Patient from storage.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Patient $patient)
    {
        if ($patient->is_default == 1) {
            return $this->sendError('This action is not allowed for default record.');
        }

        $patientModels = [
            BirthReport::class, DeathReport::class, InvestigationReport::class, OperationReport::class,
            Appointment::class, BedAssign::class, PatientAdmission::class, PatientCase::class, Bill::class,
            Invoice::class, AdvancedPayment::class, Prescription::class, IpdPatientDepartment::class,
        ];
        $result = canDelete($patientModels, 'patient_id', $patient->id);
        if ($result) {
            return $this->sendError(__('messages.advanced_payment.patient').' '.__('messages.common.cant_be_deleted'));
        }
        $patient->patientUser()->delete();
        $patient->address()->delete();
        $patient->delete();

        return $this->sendSuccess(__('messages.advanced_payment.patient').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function activeDeactiveStatus($id)
    {
        $patient = Patient::findOrFail($id);
        $status = ! $patient->patientUser->status;
        $patient->patientUser()->update(['status' => $status]);

        return $this->sendSuccess(__('messages.common.status_updated_successfully'));
    }

    public function showForm(Request $request)
    {

        $form_patientId = DB::Table('form_patient')->where(['id' => $request->formPatientID])->first();
        $fileName = "";
        if($form_patientId){
            $formFile = DB::Table('form_type')->where(['id' => $form_patientId->formID])->first();
            $fileName = $formFile->fileName;
            $formData = DB::Table('form_data')->where(['formID' => $request->formPatientID])->get();
            return view('patients.'.$fileName, compact('formData'));
        }


        return "fdsfasdf";
    }

    public function submitForm(Request $request)
    {

        $reqArray = $request->all();
        foreach ($reqArray as $fieldName => $fieldValue) {
            if ($fieldValue != null) {
                DB::table('form_data')
                    ->where('fieldName', $fieldName)->where('formID', $request->formPatientID) // Specify the condition for the update
                    ->update([
                        'fieldValue' => $fieldValue, // Update the fieldValue column with the new value
                    ]);
            }

        }

        return view('patients.blankView');

    }

    /**
     * @return BinaryFileResponse
     */
    public function patientExport()
    {
        return Excel::download(new PatientExport, 'patients-'.time().'.xlsx');
    }

    /**
     * @return Patient|Builder|Model|object|null
     */
    public function getBirthDate($id)
    {
        return Patient::whereId($id)->with('user')->first();

    }

    public function formCreat(Request $req)
    {
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->format('Y-m-d');

        $formName = DB::table('form_type')->where(['id' => $req->formName])->value('formName');
        //DB::insert("INSERT INTO `formPatient` (formID, formName, patientID, formDate) VALUES (?, ?, ?, ?)", [(int)$req->formName, $formName, (int)$req->patientID, $formattedDate]);
        $insertedId = DB::table('form_patient')->insertGetId([
            'formID' => (int) $req->formName,
            'formName' => $formName,
            'patientID' => (int) $req->patientID,
            'formDate' => $formattedDate,
        ]);

        Flash::success(__('messages.advanced_payment.patient').' Form has been added successfully');

        if ($formName == 'SOAP Form') {
            $this->insertSOAPForm($insertedId, (int) $req->patientID);
        } elseif ($formName == 'Pre-Test Form') {
            $this->insertPreTestData($insertedId, (int) $req->patientID);
        } elseif ($formName == 'Nutritional Assessment Form') {
            $this->insertNutritientData($insertedId, (int) $req->patientID);
        }

        return redirect(route('patients.show', ['patient' => $req->patientID]));

        return 'working';
    }

    public function insertNutritientData($formID, $patientID)
    {
        $data = [
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleInputFname', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'datepicker', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'datepicker2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck6', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck8', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck9', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck10', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck11', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck12', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck13', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck14', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck15', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck16', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck17', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck18', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck19', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck20', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck21', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck22', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck23', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck24', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck25', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck26', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck27', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck28', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck29', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck30', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck31', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck32', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck33', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck34', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck35', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck36', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck37', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck38', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck39', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck40', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck41', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck42', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck43', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck44', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck45', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck46', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck47', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck48', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck49', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck499', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck50', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck51', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck52', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck53', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck54', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck55', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck56', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck57', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck58', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck59', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'father_condition_1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'mother_condition_1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'siblings_condition_1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'father_condition_2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'mother_condition_2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'siblings_condition_2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'father_condition_3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'mother_condition_3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'siblings_condition_3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'father_condition_4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'mother_condition_4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'siblings_condition_4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'father_condition_5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'mother_condition_5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'siblings_condition_5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_6', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_6', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_6', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_6', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_6', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_6', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_6', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_6', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_8', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_8', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_8', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_8', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_9', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_9', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_9', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_9', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'medication_10', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'dosage_10', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'start_date_10', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'reason_10', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck60', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck61', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck62', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck63', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck64', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck65', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck66', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck67', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck68', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck69', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck70', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck71', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck72', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck73', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck74', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck75', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck76', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck77', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck78', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck79', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck80', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck81', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck82', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck83', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck84', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck85', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck86', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck87', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck88', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck89', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck90', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck91', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck92', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck93', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck94', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck95', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck96', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck97', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck98', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck99', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck100', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck101', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Noneone', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Dailyone', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weeklyone', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthlyone', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Nonetwo', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Dailytwo', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weeklytwo', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthlytwo', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Nonethree', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Dailythree', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weeklythree', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthlythree', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yesone', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Noone', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yestwo', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Notwo', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Nonefour', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Dailyfour', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weeklyfour', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthlyfour', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Noneqwe', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Dailydf', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weeklysdvf', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthlysd', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None8', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily8', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly8', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly8', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None11', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily11', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly11', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly11', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None22', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily22', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly22', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly22', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None33', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily33', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly33', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly33', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None44', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily44', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly44', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly44', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None55', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily55', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly55', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly55', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None66', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily66', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly66', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly66', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None77', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily77', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly77', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly77', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None88', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily88', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly88', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly88', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None888', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily888', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly888', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly888', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None123', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily123', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly123', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly123', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None1234', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily1234', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly1234', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly1234', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None124', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily124', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly124', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly124', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None126', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily126', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly126', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly126', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None127', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily127', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly127', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly127', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None788', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily788', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly788', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly788', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck101', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck102', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck103', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck104', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck105', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck106', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck107', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck108', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck109', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck110', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck111', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck112', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck113', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck114', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck115', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck116', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck117', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck118', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck119', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck120', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck121', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck122', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck123', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck124', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck125', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck126', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck127', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck128', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck129', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck130', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck131', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck132', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck133', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck134', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'exampleCheck135', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'daily', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'none1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'daily1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'weekly1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'monthly1', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'none2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'daily2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'weekly2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'monthly2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'none3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'daily3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'weekly3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'monthly3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'none4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'daily4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'weekly4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'monthly4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'none5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'daily5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'weekly5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'monthly5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example5', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example6', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example7', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example9', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example10', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example11', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example12', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example13', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example14', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example15', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example16', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example17', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example18', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example19', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example20', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example21', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example22', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example23', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example24', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example25', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example26', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example27', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example28', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example29', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example30', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example31', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example32', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example33', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example34', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example35', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example36', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example37', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example38', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example39', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example40', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example41', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example42', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example43', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example44', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example45', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example46', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example47', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example48', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example49', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example50', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example51', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example52', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example53', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example54', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example55', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example56', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example57', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example58', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example59', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example60', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example61', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example62', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example63', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example64', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example65', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example66', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example67', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example68', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example69', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example70', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example71', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'example72', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7019', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7019', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7019', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7019', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7020', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7020', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7020', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7020', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7021', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7021', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7021', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7021', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7022', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7022', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7022', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7022', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes22770', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No22770', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes9078', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No9078', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7025', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7025', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7025', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7025', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7026', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7026', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7026', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7026', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7027', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7027', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7027', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7027', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7028', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7028', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7028', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7028', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes90645', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No90645', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7029', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7029', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7029', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7029', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7030', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7030', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7030', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7030', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes906875', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No906875', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7031', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7031', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7031', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7031', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7032', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7032', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7032', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7032', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7033', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7033', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7033', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7033', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes906098', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No906098', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7034', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7034', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7034', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7034', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes8799715', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No8799715', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7035', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7035', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7035', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7035', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7036', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7036', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7036', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7036', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7037', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7037', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7037', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7037', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes726265', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No726265', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes989871', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No989871', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes9087456', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No9087456', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes908979', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No908979', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Yes459845', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'No459845', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7039', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7039', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7039', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7039', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7050', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7050', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7050', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7050', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7041', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7041', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7041', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7041', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7051', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7051', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7051', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7051', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7053', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7053', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7053', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7053', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7054', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7054', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7054', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7054', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7055', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7055', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7055', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7055', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7056', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7056', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7056', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7056', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7057', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7057', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7057', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7057', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7058', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7058', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7058', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7058', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7059', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7059', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7059', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7059', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7060', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7060', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7060', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7060', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7061', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7061', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7061', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7061', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7062', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7062', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7062', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7062', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7063', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7063', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7063', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7063', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7064', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7064', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7064', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7064', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7065', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7065', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7065', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7065', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'None7066', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Daily7066', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Weekly7066', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Monthly7066', 'fieldValue' => ''],
        ];

        DB::table('form_data')->insert($data);
    }

    public function insertPreTestData($formID, $patientID)
    {
        $data = [
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Mr', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Fullname', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'ResponsiblePerson', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Fatigue', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'energy', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'sleep', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'hairloss', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'stress', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'weightgain', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'constipation', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'diarrhea', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'abdominalpain', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'skinsryness', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'brainfog', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Digestion', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'IntestinalPermeability', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'GutMicrobione', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'ImuneSystem', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'NervousSystem', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Hypertension', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Diabetes', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Depression', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Anxiety', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Alziemer', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Chronic', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Eczema', 'fieldValue' => ''],
        ];

        DB::table('form_data')->insert($data);
    }

    public function insertSOAPForm($formID, $patientID)
    {
        $data = [
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Chiefcomplaint', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'HistoryofPresentIllness', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PastMedicalHistory', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Medications', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Reofviewsysemts', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'BloodPressure', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'HeartRate', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'RespiratoryRate', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Temperature', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'LaboratoryandDiagnosticTests', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Height', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'weight', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'BodyMassIndex', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'LaboratoryValues', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Diagnosis', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'DifferentialDiagnosis', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'ProblemList', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Prognosis', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'HealthStatus', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Medications2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'TestsandConsultations', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PatientEducation', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Follow-Up', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'OtherConsiderations', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'FullName', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'DateofBirth', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PhoneNumber', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Email', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Address', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'FullName2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'LicenseNumber', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PhoneNumber2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Email2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Clinic/HospitalName', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Address2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'ReasonforReferral', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'CurrentMedicalConditions', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PastMedicalHistory2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Allergies', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Medications3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => '', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'SurgicalHistory', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'FamilyMedicalHistory', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'SocialHistory', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'RelevantPhysicalExaminationFindings', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Result', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Date', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'HealthcareFacility', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'DescribeAnyTreatmentsorManagementStrategies', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'TypeofSpecialist', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PreferredSpecialist', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'AnySpecificInstructions/ConcernsRelatedToTheReferral', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Attachanyrelevantmedicalrecords,testreports,orimagingstudiesthatsupportthereferral.', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PatientName', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'DateofBirth2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Gender', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Address3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'City', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'State', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'ZipCode', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PhoneNumber3', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'EmailAddress', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'ReferringProviderName', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'ClinicName', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'Address4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'City2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'State2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PhoneNumber4', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'EmailAddress2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'DescribeTheReasonForReferral/AnySpecificConcerns', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PatientsMedicalHistory', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'CurrentMedications', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'AreThereAnyKnownAllergies', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'LaboratoryandDiagnosticTests2', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'PatientsPreviousTreatment', 'fieldValue' => ''],
            ['formID' => $formID, 'patientID' => $patientID, 'fieldName' => 'AnyAdditionalInformation', 'fieldValue' => ''],

        ];

        DB::table('form_data')->insert($data);
    }
}
