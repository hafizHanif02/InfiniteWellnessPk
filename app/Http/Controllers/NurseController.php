<?php

namespace App\Http\Controllers;

use App\Exports\NurseExport;
use App\Http\Requests\CreateNurseRequest;
use App\Http\Requests\UpdateNurseRequest;
use App\Models\EmployeePayroll;
use App\Models\Nurse;
use App\Repositories\NurseRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class NurseController extends AppBaseController
{
    /** @var NurseRepository */
    private $nurseRepository;

    public function __construct(NurseRepository $nurseRepo)
    {
        $this->nurseRepository = $nurseRepo;
    }

    /**
     * Display a listing of the Nurse.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        $data['statusArr'] = Nurse::STATUS_ARR;

        return view('nurses.index', $data);
    }

    /**
     * Show the form for creating a new Nurse.
     *
     * @return Factory|View
     */
    public function create()
    {
        $bloodGroup = getBloodGroups();

        return view('nurses.create', compact('bloodGroup'));
    }

    /**
     * Store a newly created Nurse in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateNurseRequest $request)
    {
        $input = $request->all();
        $input['status'] = ! isset($input['status']) ? 0 : 1;

        $nurse = $this->nurseRepository->store($input);

        Flash::success(__('messages.nurses').' '.__('messages.common.saved_successfully'));

        return redirect(route('nurses.index'));
    }

    /**
     * Display the specified Nurse.
     *
     * @return RedirectResponse|Redirector|View
     */
    public function show(Nurse $nurse)
    {
        $payrolls = $nurse->payrolls;

        return view('nurses.show', compact('nurse', 'payrolls'));
    }

    /**
     * Show the form for editing the specified Nurse.
     *
     * @return RedirectResponse|Redirector|View
     */
    public function edit(Nurse $nurse)
    {
        $user = $nurse->user;
        $bloodGroup = getBloodGroups();

        return view('nurses.edit', compact('user', 'nurse', 'bloodGroup'));
    }

    /**
     * Update the specified Nurse in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Nurse $nurse, UpdateNurseRequest $request)
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;

        $user = $this->nurseRepository->update($nurse, $input);

        Flash::success(__('messages.nurses').' '.__('messages.common.updated_successfully'));

        return redirect(route('nurses.index'));
    }

    /**
     * Remove the specified Nurse from storage.
     *
     * @return RedirectResponse|Redirector|JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Nurse $nurse)
    {
        $empPayRollResult = canDeletePayroll(EmployeePayroll::class, 'owner_id', $nurse->id, $nurse->user->owner_type);
        if ($empPayRollResult) {
            return $this->sendError(__('messages.nurses').' '.__('messages.common.cant_be_deleted'));
        }
        $nurse->user()->delete();
        $nurse->address()->delete();
        $nurse->delete();

        return $this->sendSuccess(__('messages.nurses').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function activeDeactiveStatus($id)
    {
        $nurse = Nurse::findOrFail($id);
        $status = ! $nurse->user->status;
        $nurse->user()->update(['status' => $status]);

        return $this->sendSuccess(__('messages.common.status_updated_successfully'));
    }

    /**
     * @return BinaryFileResponse
     */
    public function nurseExport()
    {
        return Excel::download(new NurseExport, 'nurses-'.time().'.xlsx');
    }
}
