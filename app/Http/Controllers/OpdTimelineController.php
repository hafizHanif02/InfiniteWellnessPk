<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOpdTimelineRequest;
use App\Http\Requests\UpdateOpdTimelineRequest;
use App\Models\OpdTimeline;
use App\Repositories\OpdTimelineRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

class OpdTimelineController extends AppBaseController
{
    /** @var OpdTimelineRepository */
    private $opdTimelineRepository;

    public function __construct(OpdTimelineRepository $opdTimelineRepo)
    {
        $this->opdTimelineRepository = $opdTimelineRepo;
    }

    /**
     * Display a listing of the OpdTimeline.
     *
     * @return array|string
     *
     * @throws Throwable
     */
    public function index(Request $request)
    {
        $opdTimelines = $this->opdTimelineRepository->getTimeLines($request->get('id'));

        return view('opd_timelines.index', compact('opdTimelines'))->render();
    }

    /**
     * Store a newly created OpdTimeline in storage.
     *
     * @return JsonResponse
     */
    public function store(CreateOpdTimelineRequest $request)
    {
        $input = $request->all();
        $this->opdTimelineRepository->store($input);

        return $this->sendSuccess('OPD Timeline saved successfully.');
    }

    /**
     * Show the form for editing the specified OpdTimeline.
     *
     * @return JsonResponse
     */
    public function edit(OpdTimeline $opdTimeline)
    {
        return $this->sendResponse($opdTimeline, 'OPD Timeline retrieved successfully.');
    }

    /**
     * Update the specified OpdTimeline in storage.
     *
     * @return JsonResponse
     */
    public function update(OpdTimeline $opdTimeline, UpdateOpdTimelineRequest $request)
    {
        $this->opdTimelineRepository->updateOpdTimeline($request->all(), $opdTimeline->id);

        return $this->sendSuccess('OPD Timeline updated successfully.');
    }

    /**
     * Remove the specified OpdTimeline from storage.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(OpdTimeline $opdTimeline)
    {
        $this->opdTimelineRepository->deleteOpdTimeline($opdTimeline->id);

        return $this->sendSuccess('OPD Timeline deleted successfully.');
    }

    /**
     * @return Media
     */
    public function downloadMedia(OpdTimeline $opdTimeline)
    {
        $media = $opdTimeline->getMedia(OpdTimeline::OPD_TIMELINE_PATH)->first();
        if ($media) {
            return $media;
        }

        return '';
    }
}
