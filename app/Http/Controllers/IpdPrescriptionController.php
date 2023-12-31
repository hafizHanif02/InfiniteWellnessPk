<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIpdPrescriptionRequest;
use App\Http\Requests\UpdateIpdPrescriptionRequest;
use App\Models\IpdPrescription;
use App\Queries\IpdPrescriptionDataTable;
use App\Repositories\IpdPrescriptionRepository;
use DataTables;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Response;
use Throwable;

class IpdPrescriptionController extends AppBaseController
{
    /** @var IpdPrescriptionRepository */
    private $ipdPrescriptionRepository;

    public function __construct(IpdPrescriptionRepository $ipdPrescriptionRepo)
    {
        $this->ipdPrescriptionRepository = $ipdPrescriptionRepo;
    }

    /**
     * Display a listing of the IpdPrescription.
     *
     * @return Response
     *
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new IpdPrescriptionDataTable())->get($request->get('id')))->make(true);
        }
    }

    /**
     * Store a newly created IpdPrescription in storage.
     *
     * @return JsonResponse
     */
    public function store(CreateIpdPrescriptionRequest $request)
    {
        $input = $request->all();
        $this->ipdPrescriptionRepository->store($input);
        $this->ipdPrescriptionRepository->createNotification($input);

        return $this->sendSuccess(__('messages.ipd_prescription').' '.__('messages.common.saved_successfully'));
    }

    /**
     * Display the specified IPD Prescription.
     *
     * @return array|string
     *
     * @throws Throwable
     */
    public function show(IpdPrescription $ipdPrescription)
    {
        return view('ipd_prescriptions.show_ipd_prescription_data', compact('ipdPrescription'))->render();
    }

    /**
     * Show the form for editing the specified IpdPrescription.
     *
     * @return JsonResponse
     */
    public function edit(IpdPrescription $ipdPrescription)
    {
        $ipdPrescriptionData = $this->ipdPrescriptionRepository->getIpdPrescriptionData($ipdPrescription);

        return $this->sendResponse($ipdPrescriptionData, 'Prescription retrieved successfully.');
    }

    /**
     * Update the specified IpdPrescriptionItem in storage.
     *
     * @return JsonResponse
     */
    public function update(IpdPrescription $ipdPrescription, UpdateIpdPrescriptionRequest $request)
    {
        $this->ipdPrescriptionRepository->updateIpdPrescriptionItems($request->all(), $ipdPrescription);

        return $this->sendSuccess(__('messages.ipd_prescription').' '.__('messages.common.updated_successfully'));
    }

    /**
     * Remove the specified IpdPrescriptionItem from storage.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(IpdPrescription $ipdPrescription)
    {
        $ipdPrescription->ipdPrescriptionItems()->delete();
        $ipdPrescription->delete();

        return $this->sendSuccess(__('messages.ipd_prescription').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @return JsonResponse
     */
    public function getMedicineList(Request $request)
    {
        $chargeCategories = $this->ipdPrescriptionRepository->getMedicines($request->get('id'));

        return $this->sendResponse($chargeCategories, 'Retrieved successfully');
    }
}
