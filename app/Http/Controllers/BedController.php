<?php

namespace App\Http\Controllers;

use App\Exports\BedExport;
use App\Http\Requests\CreateBedRequest;
use App\Http\Requests\CreateBulkBedRequest;
use App\Http\Requests\UpdateBedRequest;
use App\Models\Bed;
use App\Models\BedAssign;
use App\Models\IpdPatientDepartment;
use App\Repositories\BedRepository;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BedController extends AppBaseController
{
    /** @var BedRepository */
    private $bedRepository;

    public function __construct(BedRepository $bedRepo)
    {
        $this->bedRepository = $bedRepo;
    }

    /**
     * Display a listing of the Bed.
     *
     * @param  Request  $request
     * @return Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        $data['statusArr'] = Bed::STATUS_ARR;

        $bedTypes = $this->bedRepository->getBedTypes();

        return view('beds.index', compact('bedTypes'), $data);
    }

    /**
     * Store a newly created Bed in storage.
     *
     * @return JsonResponse
     */
    public function store(CreateBedRequest $request)
    {
        $input = $request->all();
        $input['charge'] = removeCommaFromNumbers($input['charge']);

        $bed = $this->bedRepository->store($input);

        return $this->sendSuccess(__('messages.bed.bed').' '.__('messages.common.saved_successfully'));
    }

    /**
     * Display the specified Bed.
     *
     * @return Factory|View
     */
    public function show(Bed $bed)
    {
        $bedAssigns = $bed->bedAssigns()->orderBy('created_at', 'desc')->get();
        $bedTypes = $this->bedRepository->getBedTypes();

        return view('beds.show', compact('bed', 'bedAssigns', 'bedTypes'));
    }

    /**
     * Show the form for editing the specified Bed.
     *
     * @return JsonResponse
     */
    public function edit(Bed $bed)
    {
        return $this->sendResponse($bed, 'Bed retrieved successfully.');
    }

    /**
     * Update the specified Bed in storage.
     *
     * @return JsonResponse
     */
    public function update(Bed $bed, UpdateBedRequest $request)
    {
        $input = $request->all();
        $input['charge'] = removeCommaFromNumbers($input['charge']);

        $bed = $this->bedRepository->update($input, $bed->id);

        return $this->sendSuccess(__('messages.bed.bed').' '.__('messages.common.updated_successfully'));
    }

    /**
     * Remove the specified Bed from storage.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Bed $bed)
    {
        $bedModel = [
            BedAssign::class, IpdPatientDepartment::class,
        ];
        $result = canDelete($bedModel, 'bed_id', $bed->id);
        if ($result) {
            return $this->sendError(__('messages.bed.bed').' '.__('messages.common.cant_be_deleted'));
        }
        $this->bedRepository->delete($bed->id);

        return $this->sendSuccess(__('messages.bed.bed').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function activeDeActiveStatus($id)
    {
        $bed = Bed::findOrFail($id);
        $bed->status = ! $bed->status;
        $bed->update(['status' => $bed->status]);

        return $this->sendSuccess(__('messages.common.status_updated_successfully'));
    }

    /**
     * @return Factory|View
     */
    public function createBulkBeds()
    {
        $bedTypes = $this->bedRepository->getBedTypes();
        $associateBedTypes = $this->bedRepository->getAssociateBedsList();

        return view('beds.create_bulk_beds', compact('bedTypes', 'associateBedTypes'));
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function storeBulkBeds(CreateBulkBedRequest $request)
    {
        $input = $request->all();
        $bulkBeds = $this->bedRepository->storeBulkBeds($input);

        return $this->sendResponse($bulkBeds, __('messages.bed.bed').' '.__('messages.common.saved_successfully'));
    }

    /**
     * @return BinaryFileResponse
     */
    public function bedExport()
    {
        return Excel::download(new BedExport, 'beds-'.time().'.xlsx');
    }
}
