<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIpdTimelineRequest;
use App\Http\Requests\UpdateIpdTimelineRequest;
use App\Models\IpdTimeline;
use App\Repositories\IpdTimelineRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Throwable;

class IpdTimelineController extends AppBaseController
{
    /** @var IpdTimelineRepository */
    private $ipdTimelineRepository;

    public function __construct(IpdTimelineRepository $ipdTimelineRepo)
    {
        $this->ipdTimelineRepository = $ipdTimelineRepo;
    }

    /**
     * Display a listing of the IpdTimeline.
     *
     * @return array|string
     *
     * @throws Throwable
     */
    public function index(Request $request)
    {
        $ipdTimelines = $this->ipdTimelineRepository->getTimeLines($request->get('id'));

        return view('ipd_timelines.index', compact('ipdTimelines'))->render();
    }

    /**
     * Store a newly created IpdTimeline in storage.
     *
     * @return JsonResponse
     */
    public function store(CreateIpdTimelineRequest $request)
    {
        $input = $request->all();
        $this->ipdTimelineRepository->store($input);

        return $this->sendSuccess(__('messages.ipd_timelines').' '.__('messages.common.saved_successfully'));
    }

    /**
     * Show the form for editing the specified IpdTimeline.
     *
     * @return JsonResponse
     */
    public function edit(IpdTimeline $ipdTimeline)
    {
        return $this->sendResponse($ipdTimeline, 'IPD Timeline retrieved successfully.');
    }

    /**
     * Update the specified IpdTimeline in storage.
     *
     * @return JsonResponse
     */
    public function update(IpdTimeline $ipdTimeline, UpdateIpdTimelineRequest $request)
    {
        $this->ipdTimelineRepository->updateIpdTimeline($request->all(), $ipdTimeline->id);

        return $this->sendSuccess(__('messages.ipd_timelines').' '.__('messages.common.updated_successfully'));
    }

    /**
     * Remove the specified IpdTimeline from storage.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(IpdTimeline $ipdTimeline)
    {
        $this->ipdTimelineRepository->deleteIpdTimeline($ipdTimeline->id);

        return $this->sendSuccess(__('messages.ipd_timelines').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @return Media
     */
    public function downloadMedia(IpdTimeline $ipdTimeline)
    {
        $media = $ipdTimeline->getMedia(IpdTimeline::IPD_TIMELINE_PATH)->first();
        if ($media != null) {
            $media = $media->id;
            $mediaItem = Media::findOrFail($media);

            return $mediaItem;
        }

        return '';
    }
}
