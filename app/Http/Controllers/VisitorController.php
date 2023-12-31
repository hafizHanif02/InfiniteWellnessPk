<?php

namespace App\Http\Controllers;

use App\Exports\VisitorExport;
use App\Http\Requests\CreateVisitorRequest;
use App\Http\Requests\UpdateVisitorRequest;
use App\Models\Visitor;
use App\Repositories\VisitorRepository;
use Exception;
use Flash;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class VisitorController
 */
class VisitorController extends AppBaseController
{
    /**
     * @var  visitorRepository
     */
    private $visitorRepository;

    /**
     * VisitorController constructor.
     */
    public function __construct(VisitorRepository $visitorRepo)
    {
        $this->visitorRepository = $visitorRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Application|Factory|Response|View
     *
     * @throws Exception
     */
    public function index()
    {
        $purpose = Visitor::FILTER_PURPOSE;

        return view('visitors.index', compact('purpose'));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $purpose = Visitor::PURPOSE;
        $isEdit = false;

        return view('visitors.create', compact('purpose', 'isEdit'));
    }

    /**
     * Store a newly created Visitor in storage.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateVisitorRequest $request)
    {
        $input = $request->all();
        $input = [
            'purpose' => $request->purpose ?? null,
            'name' => $request->name ?? null,
            'phone' => $request->phone ?? null,
            'id_card' => $request->id_card ?? null,
            'no_of_person' => $request->no_of_person ?? null,
            'date' => $request->date ?? null,
            'in_time' => $request->in_time ?? null,
            'out_time' => $request->out_time ?? null,
            'note' => $request->note ?? null,
            'prefix_code' => $request->prefix_code ?? null,
        ];
        $input['phone'] = preparePhoneNumber($input, 'phone');
        $this->visitorRepository->store($input);
        Flash::success(__('messages.visitors').' '.__('messages.common.saved_successfully'));

        return redirect(route('visitors.index'));
    }

    /**
     * Show the form for editing the specified Visitor.
     *
     * @return Application|Factory|View
     */
    public function edit(Visitor $visitor)
    {
        $purpose = Visitor::PURPOSE;
        $fileExt = pathinfo($visitor->document_url, PATHINFO_EXTENSION);
        $isEdit = true;

        return view('visitors.edit', compact('visitor', 'purpose', 'fileExt', 'isEdit'));
    }

    /**
     * Update the specified Visitor in storage.
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdateVisitorRequest $request, Visitor $visitor)
    {
        $input = $request->all();
        $input['phone'] = preparePhoneNumber($input, 'phone');
        $this->visitorRepository->updateVisitor($input, $visitor->id);
        Flash::success(__('messages.visitors').' '.__('messages.common.updated_successfully'));

        return redirect(route('visitors.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     **@return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Visitor $visitor)
    {
        $this->visitorRepository->deleteDocument($visitor->id);

        return $this->sendSuccess(__('messages.visitors').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @return Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function downloadMedia(Visitor $visitor)
    {
        [$file, $headers] = $this->visitorRepository->downloadMedia($visitor);

        return response($file, 200, $headers);
    }

    /**
     * @return BinaryFileResponse
     */
    public function export()
    {
        return Excel::download(new VisitorExport, 'visitor-'.time().'.xlsx');
    }
}
