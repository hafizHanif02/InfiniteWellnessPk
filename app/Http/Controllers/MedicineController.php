<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Exception;
use App\Models\Log;
use App\Models\Pos;
use App\Models\BatchPOS;
use App\Models\Medicine;
use App\Models\PosReturn;
use Illuminate\View\View;
use App\Models\Pos_Product;
use Illuminate\Http\Request;
use App\Models\Shift\Transfer;
use App\Exports\MedicineExport;
use App\Models\PosProductReturn;
use Illuminate\Http\JsonResponse;
use App\Models\MedicineAdjustment;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Shift\TransferProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Repositories\MedicineRepository;
use App\Http\Requests\CreateMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MedicineController extends AppBaseController
{
    /** @var MedicineRepository */
    private $medicineRepository;

    public function __construct(MedicineRepository $medicineRepo)
    {
        $this->medicineRepository = $medicineRepo;
    }

    /**
     * Display a listing of the Medicine.
     *
     * @param  Request  $request
     * @return Factory|View|Response
     *
     * @throws Exception
     */
    public function index()
    {
        return view('medicines.index');
    }

    /**
     * Show the form for creating a new Medicine.
     *
     * @return Factory|View
     */
    public function create()
    {
        $data = $this->medicineRepository->getSyncList();

        return view('medicines.create')->with($data);
    }

    /**
     * Store a newly created Medicine in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(CreateMedicineRequest $request)
    {
        $input = $request->all();

        $this->medicineRepository->create($input);

        Flash::success(__('messages.medicine.medicine') . ' ' . __('messages.common.saved_successfully'));

        return redirect(route('medicines.index'));
    }

    /**
     * Display the specified Medicine.
     *
     * @return Factory|View
     */
    public function show(Medicine $medicine)
    {
        $medicine->brand;
        $medicine->category;

        return view('medicines.show')->with('medicine', $medicine);
    }

    /**
     * Show the form for editing the specified Medicine.
     *
     * @return Factory|View
     */
    public function edit(Medicine $medicine)
    {
        $data = $this->medicineRepository->getSyncList();
        $data['medicine'] = $medicine;

        return view('medicines.edit')->with($data);
    }

    /**
     * Update the specified Medicine in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function update(Medicine $medicine, UpdateMedicineRequest $request)
    {
        $this->medicineRepository->update($request->all(), $medicine->id);

        $user = Auth::user();
        Log::create([
            'action' => 'Medicine Has Been Edited Medicine Name : '.$medicine->name.' ('.$medicine->id.')',
            'action_by_user_id' => $user->id,
        ]);

        Flash::success(__('messages.medicine.medicine') . ' ' . __('messages.common.updated_successfully'));

        return redirect(route('medicines.index'));
    }

    /**
     * Remove the specified Medicine from storage.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function destroy(Medicine $medicine)
    {
        $this->medicineRepository->delete($medicine->id);

        return $this->sendSuccess(__('messages.medicine.medicine') . ' ' . __('messages.common.deleted_successfully'));
    }

    /**
     * @return BinaryFileResponse
     */
    public function medicineExport()
    {
        // return Excel::download(new MedicineExport, 'medicines-'.time().'.xlsx');
        $medicines = Medicine::with('brand')->get();
        return view('medicines.export', [
            'medicines' => $medicines
        ]);
    }

    /**
     * @return JsonResponse
     *
     * @throws \Gerardojbaez\Money\Exceptions\CurrencyException
     */
    public function showModal(Medicine $medicine)
    {
        $medicine->load(['brand', 'category']);

        $currency = $medicine->currency_symbol ? strtoupper($medicine->currency_symbol) : strtoupper(getCurrentCurrency());
        $medicine = [
            'name' => $medicine->name,
            'brand_name' => $medicine->brand->name,
            'category_name' => $medicine->category->name,
            'salt_composition' => $medicine->salt_composition,
            'side_effects' => $medicine->side_effects,
            'created_at' => $medicine->created_at,
            'selling_price' => checkNumberFormat($medicine->selling_price, $currency),
            'buying_price' => checkNumberFormat($medicine->buying_price, $currency),
            'updated_at' => $medicine->updated_at,
            'description' => $medicine->description,
        ];

        return $this->sendResponse($medicine, 'Medicine Retrieved Successfully');
    }

    public function medicinesAdjustmentShow()
    {
        return view(
            'medicines.medicine-adjustment',
            [
                'adjustment' => MedicineAdjustment::with('batchPOS')->orderBy('id', 'desc')->paginate(10),
            ]
        );
    }

    public function medicinesAdjustment()
    {
        return view('medicines.add-medicines-adjustment', [
            'medicines' => Medicine::get(),
            'adjustment_id' => MedicineAdjustment::latest()->pluck('id')->first(),
        ]);

    }

    public function getMedicines(Request $request): JsonResponse
    {
        return response()->json([
            'medicine' => Medicine::whereIn('id', $request->medicine_id)->with('AllBatchPOS.batch')->get(),
        ]);
    }

    public function medicinesAdjustmentStore(Request $request)
    {
        $user = Auth::user();
        foreach ($request->medicines as $medicine) {
            MedicineAdjustment::create([
                'medicine_id' => $medicine['medicine_id'],
                'batchPOS_id' => $medicine['batch_id'],
                'medicine_name' => $medicine['medicine_name'],
                'current_qty' => $medicine['current_qty'],
                'adjustment_qty' => $medicine['adjustment_qty'],
                'different_qty' => $medicine['different_qty'],
            ]);

            if($medicine['current_qty'] > $medicine['adjustment_qty']){
                $qty = $medicine['current_qty'] - $medicine['adjustment_qty'];
                Medicine::where('id', $medicine['medicine_id'])->update([
                    'total_quantity' => DB::raw('total_quantity - ' . $qty)
                ]);
            }else{
                $qty = $medicine['adjustment_qty'] - $medicine['current_qty'];
                Medicine::where('id', $medicine['medicine_id'])->update([
                    'total_quantity' => DB::raw('total_quantity + ' . $qty)
                ]);
            }

            BatchPOS::where('id', $medicine['batch_id'])->update([
                'remaining_qty' => $medicine['adjustment_qty'],
            ]);

            Log::create([
                'action' => 'Medicines Adjustment Has Been Created Medicine Code:'.$medicine['medicine_id'],
                'action_by_user_id' => $user->id,
            ]);
        }

        Flash::success('Medicines Adjustment created successfully.');
        return redirect(route('medicines.adjustment.show'));
    }

    public function medicinesRecalculation()
    {
        return view('medicines.medicine-Recalculation');
    }

    public function medicinesRecalculate()
    {
        $medicines = Medicine::select(['medicines.id', 'product_id', 'name', 'total_quantity'])->get();
        $user = Auth::user();
        Log::create([
            'action' => 'All Medicine Has Been Recalculated',
            'action_by_user_id' => $user->id,
        ]);

        $approvedpos = Pos::where('is_paid', 1)->select('id')->get();

        foreach ($medicines as $medicine) {
            $pos = Pos_Product::where('medicine_id', $medicine->id)->whereIn('pos_id', $approvedpos)
                ->sum('product_quantity');

            $posReturn = PosProductReturn::where('medicine_id', $medicine->id)
                ->sum('product_quantity');

            $transfer = TransferProduct::where('product_id', $medicine->product_id)
                ->whereHas('transfer', function ($query) {
                    $query->where('status', 1);
                })
                ->sum('total_piece');

            $different_qty = MedicineAdjustment::where('medicine_id', $medicine->id)->OrderBy('id', 'desc')
                ->sum('different_qty');

            $updated_qty = $transfer - $pos + $posReturn + ($different_qty);


            $medicine->total_quantity = $updated_qty;
            $medicine->save();
            // $data = 'Pos ='. $pos . ' Transfer ='. $transfer . ' Pos Return ='. $posReturn . ' Different Qty ='. $different_qty . ' Updated Qty ='. $updated_qty;
            // dd($data);
        }

        $user = Auth::user();
        Log::create([
            'action' => 'Recalculation Has Been Executed ',
            'action_by_user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Medicine recalculation successfully.',
            'medicines' => $medicines
        ]);
    }

    public function batchPosReport(Request $request)
    {
        $query = Medicine::query();

        if ($request->has('search_data')) {
            $searchTerm = $request->search_data;
            $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('id', '=', $searchTerm );
        }

        $batches = $query->paginate(10)->onEachSide(1);

        return view('medicines.batch_report.batchreports', [
            'batches' => $batches,
            'search_data' => $request->search_data ?? ''
        ]);
    }

    public function batchPosReportShow($id)
    {

        $batches = BatchPOS::where('product_id', $id)->get();
    $product = Medicine::find($id);

    return view('medicines.batch_report.batchReportShow', [
        'batches' => $batches,
        // 'product' => $product,
    ]);
}

public function medicinesHistory($id){
    $product = Medicine::find($id);
    $productId = $product->product_id;
    $transfer = TransferProduct::where('product_id', $productId)
    ->whereHas('transfer', function ($query) {
        $query->where('status', 1);
    })->orderBy('created_at', 'asc')
    ->get();
    $posProduct = Pos_Product::where('medicine_id', $id)
    ->whereHas('pos', function ($query) {
        $query->where('is_paid', 1);
    })
    ->orderBy('created_at', 'asc')
    ->get();
    $posProductReturn = PosProductReturn::where('medicine_id', $id)
    ->orderBy('created_at', 'asc')
    ->get();
    
    return view('medicines.medicinesHistory', compact('product', 'posProduct', 'posProductReturn', 'transfer'));
}
}
