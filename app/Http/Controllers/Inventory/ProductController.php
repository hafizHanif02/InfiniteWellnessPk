<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Patient;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Inventory\Dosage;
use App\Models\Inventory\Vendor;
use App\Models\Inventory\Generic;
use App\Models\Inventory\Product;
use App\Models\Inventory\StockIn;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\OpdPatientDepartment;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Shift\TransferProduct;
use Illuminate\Http\RedirectResponse;
use App\Models\Inventory\Manufacturer;
use App\Imports\Inventory\ProductImport;
use App\Models\Inventory\ProductCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\DentalOpdPatientDepartment;
use App\Models\Purchase\GoodReceiveProduct;
use App\Http\Requests\Inventory\ProductRequest;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        if(isset($request->search_data)){
            return view('inventory.products.index', [
                'products' => Product::where('product_name', 'LIKE', '%' . $request->search_data . '%')->with('goodReceiveProducts')->paginate(5)->setPath(''),
                'search_data' => $request->search_data
            ]); 
        }
        return view('inventory.products.index', [
            'products' => Product::with('goodReceiveProducts')->orderBy('product_name', 'asc')->latest()->paginate(10)->onEachSide(1),
            'search_data' => ''
        ]);
    }
    public function exportToExcel(){
        $product = Product::get();
        return view('inventory.products.export',[
            'porducts' => $product
        ]);
    }

    public function importExcel(Request $request): RedirectResponse
    {
        Excel::import(new ProductImport, storage_path('app/public/'.request()->file('products_csv')->store('products-excel-files', 'public')));

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

        return response()->json([
            'data' => Manufacturer::create($validator->validated()),
        ], 200);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        // dd($request);
        Product::create($request->validated()+['open_quantity' => $request->total_quantity, 'total_quantity' => 0]);
        // StockIn::create($request->validated());

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
            'vendors' => Vendor::orderBy('contact_person')->get(['id','contact_person']),
            'product' => $product,
            'dosage_id' => Dosage::latest()->pluck('id')->first(),
            'manufacturer_id' => Manufacturer::latest()->pluck('id')->first(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated()+['open_quantity' => $request->total_quantity]);

        return to_route('inventory.products.index')->with('success', 'Product updated!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return back()->with('success', 'Product deleted!');
    }


    public function form(){
        return view('inventory.products.form',[
            'patients' => Patient::with('user')->get(),
        ]);
    }


    public function opd(Request $request)
    {

        $getPatientID = Patient::where(['MR'=> $request->patient_mr_number])->get();

        if(count($getPatientID) > 0){
            return response()->json([
                'data' => OpdPatientDepartment::where('patient_id',$getPatientID[0]->id)->with('patient.user','doctor.user')->get(),
                'data2' => DentalOpdPatientDepartment::where('patient_id',$getPatientID[0]->id)->with('patient.user')->get(),
            ]);
        }


        return response()->json([
            'data' => ''
        ]);
    }

    public function search(Request $request){
        return $request->search_data;
    }

   
    
}
