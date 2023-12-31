<?php

namespace App\Http\Controllers;

use App\Exports\PharmacistExport;
use App\Http\Requests\CreatePharmacistRequest;
use App\Http\Requests\UpdatePharmacistRequest;
use App\Models\EmployeePayroll;
use App\Models\Pharmacist;
use App\Repositories\PharmacistRepository;
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

class PharmacistController extends AppBaseController
{
    /** @var PharmacistRepository */
    private $pharmacistRepository;

    public function __construct(PharmacistRepository $pharmacistRepo)
    {
        $this->pharmacistRepository = $pharmacistRepo;
    }

    /**
     * Display a listing of the Pharmacist.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        $data['statusArr'] = Pharmacist::STATUS_ARR;

        return view('pharmacists.index', $data);
    }

    /**
     * Show the form for creating a new Pharmacist.
     *
     * @return Factory|View
     */
    public function create()
    {
        $bloodGroup = getBloodGroups();

        return view('pharmacists.create', compact('bloodGroup'));
    }

    /**
     * Store a newly created Pharmacist in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreatePharmacistRequest $request)
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;

        $this->pharmacistRepository->store($input);
        Flash::success(__('messages.pharmacists').' '.__('messages.common.saved_successfully'));

        return redirect(route('pharmacists.index'));
    }

    /**
     * Display the specified Pharmacist.
     *
     * @return Factory|View
     */
    public function show(Pharmacist $pharmacist)
    {
        $payrolls = $pharmacist->payrolls;

        return view('pharmacists.show', compact('pharmacist', 'payrolls'));
    }

    /**
     * Show the form for editing the specified Pharmacist.
     *
     * @return Factory|View
     */
    public function edit(Pharmacist $pharmacist)
    {
        $user = $pharmacist->user;
        $bloodGroup = getBloodGroups();

        return view('pharmacists.edit', compact('pharmacist', 'user', 'bloodGroup'));
    }

    /**
     * Update the specified Pharmacist in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Pharmacist $pharmacist, UpdatePharmacistRequest $request)
    {
        $input = $request->all();
        $input['status'] = isset($input['status']) ? 1 : 0;
        $this->pharmacistRepository->update($input, $pharmacist);

        Flash::success(__('messages.pharmacists').' '.__('messages.common.updated_successfully'));

        return redirect(route('pharmacists.index'));
    }

    /**
     * Remove the specified Pharmacist from storage.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Pharmacist $pharmacist)
    {
        $empPayRollResult = canDeletePayroll(EmployeePayroll::class, 'owner_id', $pharmacist->id, $pharmacist->user->owner_type);
        if ($empPayRollResult) {
            return $this->sendError(__('messages.pharmacists').' '.__('messages.common.cant_be_deleted'));
        }
        $pharmacist->user()->delete();
        $pharmacist->delete();
        $pharmacist->address()->delete();

        return $this->sendSuccess(__('messages.pharmacists').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function activeDeactiveStatus($id)
    {
        $pharmacist = Pharmacist::findOrFail($id);
        $status = ! $pharmacist->user->status;
        $pharmacist->user()->update(['status' => $status]);

        return $this->sendSuccess(__('messages.common.status_updated_successfully'));
    }

    /**
     * @return BinaryFileResponse
     */
    public function pharmacistExport()
    {
        return Excel::download(new PharmacistExport, 'pharmacists-'.time().'.xlsx');
    }
}
