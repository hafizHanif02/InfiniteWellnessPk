<?php

namespace App\Http\Controllers;

use App\Exports\IncomeExport;
use App\Http\Requests\CreateIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Models\Income;
use App\Repositories\IncomeRepository;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class IncomeController extends AppBaseController
{
    /**
     * @var IncomeRepository
     */
    private $incomeRepository;

    public function __construct(IncomeRepository $incomeRepository)
    {
        $this->incomeRepository = $incomeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Application|Factory|View
     *
     * @throws Exception
     */
    public function index()
    {
        $incomeHeads = Income::INCOME_HEAD;
        asort($incomeHeads);
        $filterIncomeHeads = Income::FILTER_INCOME_HEAD;
        asort($filterIncomeHeads);

        return view('incomes.index', compact('incomeHeads', 'filterIncomeHeads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(CreateIncomeRequest $request)
    {
        $input = $request->all();
        $input['amount'] = removeCommaFromNumbers($input['amount']);
        $this->incomeRepository->store($input);
        $this->incomeRepository->createNotification($input);

        return $this->sendSuccess(__('messages.income').' '.__('messages.common.saved_successfully'));
    }

    /**
     * @return Application|Factory|View
     */
    public function show(Income $income)
    {
        $incomes = $this->incomeRepository->find($income->id);
        $incomeHeads = Income::INCOME_HEAD;
        asort($incomeHeads);

        return view('incomes.show', compact('incomes', 'incomeHeads'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return JsonResponse
     */
    public function edit(Income $income)
    {
        return $this->sendResponse($income, 'Income retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return JsonResponse
     */
    public function update(UpdateIncomeRequest $request, Income $income)
    {
        $this->incomeRepository->updateExpense($request->all(), $income->id);

        return $this->sendSuccess(__('messages.income').' '.__('messages.common.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Income $income)
    {
        $this->incomeRepository->deleteDocument($income->id);

        return $this->sendSuccess(__('messages.income').' '.__('messages.common.deleted_successfully'));
    }

    /**
     * @return ResponseFactory|\Illuminate\Http\Response
     *
     * @throws FileNotFoundException
     */
    public function downloadMedia(Income $income)
    {
        $documentMedia = $income->media[0];
        $documentPath = $documentMedia->getPath();
        if (config('app.media_disc') === 'public') {
            $documentPath = (Str::after($documentMedia->getUrl(), '/uploads'));
        }

        $file = Storage::disk(config('app.media_disc'))->get($documentPath);

        $headers = [
            'Content-Type' => $income->media[0]->mime_type,
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => "attachment; filename={$income->media[0]->file_name}",
            'filename' => $income->media[0]->file_name,
        ];

        return response($file, 200, $headers);
    }

    /**
     * @return BinaryFileResponse
     */
    public function incomeExport()
    {
        return Excel::download(new IncomeExport, 'incomes-'.time().'.xlsx');
    }
}
