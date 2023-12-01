<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Log;
use App\Models\Batch;
use App\Models\Patient;
use App\Models\BatchPOS;
use App\Models\Medicine;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Inventory\Dosage;
use App\Models\Inventory\Vendor;
use App\Models\AdjustmentProduct;
use App\Models\Inventory\Generic;
use App\Models\Inventory\Product;
use App\Models\Inventory\StockIn;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase\Requistion;
use App\Http\Controllers\Controller;
use App\Models\OpdPatientDepartment;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Shift\TransferProduct;
use Illuminate\Http\RedirectResponse;
use App\Models\Inventory\Manufacturer;
use App\Imports\Inventory\ProductImport;
use App\Models\Inventory\ProductCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\DentalOpdPatientDepartment;
use App\Models\Purchase\GoodReceiveProduct;
use App\Models\Purchase\PurchaseReturnNote;
use App\Http\Requests\Inventory\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        if (isset($request->search_data)) {
            return view('inventory.products.index', [
                'products' => Product::where('product_name', 'LIKE', '%' . $request->search_data . '%')->orWhere('id', 'LIKE', '%' . $request->search_data . '%')->with('goodReceiveProducts')->paginate(5)->setPath(''),
                'search_data' => $request->search_data
            ]);
        }
        return view('inventory.products.index', [
            'products' => Product::with('goodReceiveProducts')->orderBy('product_name', 'asc')->latest()->paginate(10)->onEachSide(1),
            'search_data' => ''
        ]);
    }
    // public function exportToExcel()
    // {
    //     $product = Product::get();
    //     return view('inventory.products.export', [
    //         'porducts' => $product
    //     ]);
    // }

    public function exportToExcel()
    {
        $products = Product::leftJoin('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->leftJoin('generics', 'products.generic_id', '=', 'generics.id')
            ->leftJoin('manufacturers', 'products.manufacturer_id', '=', 'manufacturers.id')
            ->leftJoin('dosages', 'products.dosage_id', '=', 'dosages.id') // Join with the dosages table
            ->select(
                'products.*',
                'product_categories.name as category_name',
                'generics.formula as generic_formula',
                'manufacturers.company_name as manufacturer_name',
                'dosages.name as dosage_name' // Select the 'name' column from the dosages table
            )
            ->orderBy('products.id')
            ->get();
    
        return view('inventory.products.export', [
            'products' => $products,
            // Other variables you want to pass to the view
        ]);
    }

    public function importExcel(Request $request): RedirectResponse
    {
        Excel::import(new ProductImport, storage_path('app/public/' . request()->file('products_csv')->store('products-excel-files', 'public')));
        return back()->with('success', 'Imported successfully!');
    }

    public function create(): View
    {
        return view('inventory.products.create', [
            'productCategories' => ProductCategory::orderBy('name')->get(),
            'dosages' => Dosage::orderBy('name')->get(),
            'generics' => Generic::orderBy('formula')->get(),
            'manufacturers' => Manufacturer::orderBy('company_name')->get(['id', 'company_name']),
            'vendors' => Vendor::orderBy('contact_person')->get(),
            'product_id' => Product::latest()->pluck('id')->first(),
            'dosage_id' => Dosage::latest()->pluck('id')->first(),
            'manufacturer_id' => Manufacturer::latest()->pluck('id')->first(),
        ]);
    }

    public function storeProductCategory(Request $request): JsonResponse
    {   
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:product_categories,name'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        $user = Auth::user();
        Log::create([
            'action' => 'Product Category Has Been Created Category Name: '.$request->name,
            'action_by_user_id' => $user->id,
        ]);

        return response()->json([
            'data' => ProductCategory::create($validator->validated()),
        ], 200);
    }

    public function storeGeneric(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'formula' => ['required', 'string', 'max:255', 'unique:generics,formula'],
            'generic_detail' => ['nullable', 'string'],
        ]);
        $user = Auth::user();
        Log::create([
            'action' => 'Generic Formula Has Been Created Generic Formula: '.$request->formula.' Generic Code ('.$request->code.')',
            'action_by_user_id' => $user->id,
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        return response()->json([
            'data' => Generic::create($validator->validated()),
        ], 200);
    }

    public function storeDosage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:dosages,name'],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        $dosage = Dosage::create($validator->validated());

        $user = Auth::user();
        Log::create([
            'action' => 'Dosage Has Been Created Dosage Form Name: '.$dosage->name.' Code ('.$dosage->id.')',
            'action_by_user_id' => $user->id,
        ]);
        return response()->json([
            'data' => $dosage,
        ], 200);
    }

    public function storeVendor(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'manufacturer_id' => ['required', 'exists:manufacturers,id'],
            'account_title' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email'],
            'address' => ['required', 'string', 'max:255'],
            'ntn' => ['required', 'integer'],
            'sales_tax_reg' => ['required', 'integer'],
            'active' => ['required', 'integer', 'max:255'],
            'area' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
        ]);

       

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }

        return response()->json([
            'data' => Vendor::create($validator->validated()),
        ], 200);
    }

    public function storeManufacturer(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'company_name' => ['required', 'string', 'max:255', 'unique:manufacturers,company_name']
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }
        
        $user = Auth::user();
        Log::create([
            'action' => 'Manufacturer Has Been Created Company Name: '.$request->company_name.' Code ('.$request->code.')',
            'action_by_user_id' => $user->id,
        ]);

        return response()->json([
            'data' => Manufacturer::create($validator->validated()),
        ], 200);


    }

    public function store(ProductRequest $request): RedirectResponse
    {

        $product = Product::create($request->validated() + ['open_quantity' => $request->total_quantity, 'total_quantity' => 0]);

        $user = Auth::user();
        Log::create([
            'action' => 'Product Has Been Created Product Name: '.$request->product_name.' ('.$product->id.')',
            'action_by_user_id' => $user->id,
        ]);

        return to_route('inventory.products.index')->with('success', 'Product created!');
    }

    public function show(Product $product): View
    {
        return view('inventory.products.show', [
            'product' => $product,
        ]);
    }

    public function edit(Product $product): View
    {
        return view('inventory.products.edit', [
            'productCategories' => ProductCategory::orderBy('name')->get(),
            'dosages' => Dosage::orderBy('name')->get(),
            'generics' => Generic::orderBy('formula')->get(),
            'manufacturers' => Manufacturer::orderBy('company_name')->get(['id', 'company_name']),
            'vendors' => Vendor::orderBy('contact_person')->get(['id', 'contact_person']),
            'product' => $product,
            'dosage_id' => Dosage::latest()->pluck('id')->first(),
            'manufacturer_id' => Manufacturer::latest()->pluck('id')->first(),
        ]);
      
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated() + ['open_quantity' => $request->total_quantity]);

        $user = Auth::user();
        Log::create([
            'action' => 'Product Has Been Edited Product Name: '.$product->product_name.' ('.$product->id.')',
            'action_by_user_id' => $user->id,
        ]);

        return to_route('inventory.products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        $user = Auth::user();
        Log::create([
            'action' => 'Product Has Been Deleted Product Name: '.$product->product_name.' ('.$product->id.')',
            'action_by_user_id' => $user->id,
        ]);

        return back()->with('success', 'Product deleted!');
    }


    public function form()
    {
        return view('inventory.products.form', [
            'patients' => Patient::with('user')->get(),
        ]);
    }


    public function opd(Request $request)
    {
        $getPatientID = Patient::where(['MR' => $request->patient_mr_number])->get();

        if (count($getPatientID) > 0) {
            return response()->json([
                'data' => OpdPatientDepartment::where('patient_id', $getPatientID[0]->id)->with('patient.user', 'doctor.user')->get(),
                'data2' => DentalOpdPatientDepartment::where('patient_id', $getPatientID[0]->id)->with('patient.user')->get(),
            ]);
        }


        return response()->json([
            'data' => ''
        ]);
    }

    public function search(Request $request)
    {
        return $request->search_data;
    }



    public function productsReport(Request $request)
    {
        $productsQuery = Product::with('generic')->select(['products.id', 'product_name', 'open_quantity', 'total_quantity', 'generic_id']);

        if ($request->date_from || $request->date_to) {
            $productsQuery->leftJoin('good_receive_products', 'products.id', '=', 'good_receive_products.product_id')
                ->leftJoin('transfer_products', 'products.id', '=', 'transfer_products.product_id')
                ->groupBy('products.id', 'product_name', 'open_quantity');

            if ($request->date_from) {
                $productsQuery->where('good_receive_products.created_at', '>=', $request->date_from);
            }

            if ($request->date_to) {
                $productsQuery->where('good_receive_products.created_at', '<=', $request->date_to);
            }

            if ($request->date_from) {
                $productsQuery->where('transfer_products.created_at', '>=', $request->date_from);
            }

            if ($request->date_to) {
                $productsQuery->where('transfer_products.created_at', '<=', $request->date_to);
            }
        }

        $products = $productsQuery->get();

        foreach ($products as $product) {
            $stock_in = GoodReceiveProduct::where('product_id', $product->id)->sum('deliver_qty');
            $stock_out = TransferProduct::where('product_id', $product->id)->sum('total_piece');

            $product->stock_in = $stock_in;
            $product->stock_out = $stock_out;

            $stock_current = $stock_in - $stock_out;
            $product->stock_current = $stock_current;

            $product->open_quantity = ($stock_current + $stock_out) - ($stock_in);
        }
        return view('inventory.product_report.index', ['products' => $products]);
    }

    public function productsReportPrint(Request $request)
    {
        $productsQuery = Product::with('generic')->select(['products.id', 'product_name', 'open_quantity', 'total_quantity', 'generic_id']);

        if ($request->date_from || $request->date_to) {
            $productsQuery->leftJoin('good_receive_products', 'products.id', '=', 'good_receive_products.product_id')
                ->leftJoin('transfer_products', 'products.id', '=', 'transfer_products.product_id')
                ->groupBy('products.id', 'product_name', 'open_quantity');

            if ($request->date_from) {
                $productsQuery->where('good_receive_products.created_at', '>=', $request->date_from);
            }

            if ($request->date_to) {
                $productsQuery->where('good_receive_products.created_at', '<=', $request->date_to);
            }

            if ($request->date_from) {
                $productsQuery->where('transfer_products.created_at', '>=', $request->date_from);
            }

            if ($request->date_to) {
                $productsQuery->where('transfer_products.created_at', '<=', $request->date_to);
            }
        }

        $products = $productsQuery->get();

        foreach ($products as $product) {
            $stock_in = GoodReceiveProduct::where('product_id', $product->id)->sum('deliver_qty');
            $stock_out = TransferProduct::where('product_id', $product->id)->sum('total_piece');

            $product->stock_in = $stock_in;
            $product->stock_out = $stock_out;

            $stock_current = $stock_in - $stock_out;
            $product->stock_current = $stock_current;

            $product->open_quantity = ($stock_current + $stock_out) - ($stock_in);
        }

        return view('inventory.product_report.print', ['products' => $products]);
    }

    public function recalculation()
    {
        return view('inventory.products.recalculation');
    }

    public function recalculate()
    {
        $products = Product::select(['products.id', 'product_name', 'total_quantity', 'open_quantity'])->get();

        foreach ($products as $product) {
            $stock_in = GoodReceiveProduct::where('product_id', $product->id)
                ->whereHas('goodReceiveNote', function ($query) {
                    $query->where('is_approved', 1);
                })
                ->sum('deliver_qty');
            $purchaseReturnProducts = PurchaseReturnNote::where('status', 1)->where('product_id', $product->id)->sum('quantity');
            $stock_out = TransferProduct::where('product_id', $product->id)
                ->whereHas('transfer', function ($query) {
                    $query->where('status', 1);
                })
                ->sum('total_piece');
            $different_qty = AdjustmentProduct::where('product_id', $product->id)->OrderBy('id', 'desc')
                ->sum('different_qty');

            // $product->stock_out = $stock_out;
            // $product->stock_in = $stock_in;
            // if(count($different_qty) > 0){
            //     $different_qty = $different_qty[0]->different_qty;
            // }else{
            //     $different_qty = 0;
            // };
            $updated_qty = $stock_in - $purchaseReturnProducts - $stock_out + ($different_qty);
            // $product->total_quantity = $updated_qty;

            // Update the 'total_quantity' column in the database
            $product->total_quantity = $updated_qty;
            $product->save();
            // $data = "GRN = " . $stock_in . " - PRN = " . $purchaseReturnProducts . " - TRN = " . $stock_out . " + APN = " . $different_qty . " = " . $updated_qty;
            // dd($data);
        }

        $user = Auth::user();
        Log::create([
            'action' => 'All Inventory Product Has Been Recalculated',
            'action_by_user_id' => $user->id,
        ]);

        
        return response()->json([
            'success' => true,
            'message' => 'Product recalculation successfully.',
            'products' => $products
        ]);
    }

    public function adjustment()
    {
        return view(
            'inventory.products.adjustment',
            [
                'adjustment' => AdjustmentProduct::orderBy('id', 'desc')->paginate(10),
            ]
        );
    }

    public function adjustmentCreate()
    {
        return view('inventory.products.adjustment_create', [
            'adjustment_id' => AdjustmentProduct::latest()->pluck('id')->first(),
            'vendors' => Vendor::orderBy('account_title')->get(['id', 'account_title']),
            'manufactuters' => Manufacturer::orderBy('company_name')->get(['id', 'company_name']),
            'products' => Product::orderBy('id')->with('generic')->get(),
        ]);
    }
    
    public function getProduct(Request $request): JsonResponse
    {
        return response()->json([
            'product' => Product::whereIn('id', $request->product_id)->with('AllBatch')->get(),
        ]);
    }

    public function adjustmentStore(Request $request)
    {
        $user = Auth::user();
        foreach ($request->products as $product) {
            AdjustmentProduct::create([
                'product_id' => $product['product_id'],
                'batch_id' => $product['batch_id'],
                'product_name' => $product['product_name'],
                'current_qty' => $product['current_qty'],
                'adjustment_qty' => $product['adjustment_qty'],
                'different_qty' => $product['different_qty'],
            ]);

            if ($product['current_qty'] > $product['adjustment_qty']) {
            $qty = $product['current_qty'] - $product['adjustment_qty'];
                    
            Product::where('id', $product['product_id'])->update([
                'total_quantity' => DB::raw('total_quantity - ' . $qty)
            ]);
        
            } else {
                $qty = $product['adjustment_qty'] - $product['current_qty'];
            
                Product::where('id', $product['product_id'])->update([
                    'total_quantity' => DB::raw('total_quantity + ' . $qty)
                ]);
            }


            Batch::where('id', $product['batch_id'])->update([
                'remaining_qty' => $product['adjustment_qty'],
            ]);

            Log::create([
                'action' => 'Products Adjustment Has Been Created Product Code:'.$product['product_id'],
                'action_by_user_id' => $user->id,
            ]);       
        }

        return redirect('/inventory/adjustment')->with('success', 'Adjustment created successfully.');
    }

public function batchPosReport(Request $request)
{
    $query = Product::query();

    if ($request->has('search_data')) {
        $searchTerm = $request->search_data;
        $query->where('product_name', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('id', '=', $searchTerm );
    }

    $batches = $query->paginate(10)->onEachSide(1);

    return view('inventory.batch_report.batchreport', [
        'batches' => $batches,
        'search_data' => $request->search_data ?? ''
    ]);
}

public function batchPosReportShow($id)
{
    $batches = Batch::where('product_id', $id)->get();
    $product = Product::find($id);
    // dd($product);

    return view('inventory.batch_report.batchReportShow', [
        'batches' => $batches,
        'product' => $product,
    ]);
}
}
