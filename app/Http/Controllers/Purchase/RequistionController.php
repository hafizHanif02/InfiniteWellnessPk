<?php

namespace App\Http\Controllers\Purchase;

use App\Models\Purchase\GoodReceiveNote;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Inventory\Vendor;
use App\Models\Inventory\Product;
use Illuminate\Http\JsonResponse;
use App\Models\Purchase\Requistion;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Imports\Purchase\RequistionImport;
use App\Models\Purchase\RequistionProduct;
use App\Http\Requests\Purchase\RequistionRequest;
use App\Imports\Purchase\RequistionDocumentImport;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RequistionController extends Controller
{
    public function index(): View
    {
        return view('purchase.requistion.index', [
            'requistions' => Requistion::with('vendor')->whereHas('requistionProducts', function ($query) {
                $query->where('is_approved', null);
            })->latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'requistions_csv' => ['required', 'file', 'mimes:xlsx']
        ]);
        Excel::import(new RequistionImport, storage_path('app/public/' . request()->file('requistions_csv')->store('requistions-excel-files', 'public')));

        return back()->with('success', 'Imported successfully!');
    }

    public function importDocument(Request $request): JsonResponse
    {
        $request->validate([
            'document' => ['required', 'file', 'mimes:xlsx']
        ]);

        $data = Excel::toCollection(new RequistionDocumentImport, storage_path('app/public/' . request()->file('document')->store('requistion-document-excel-files', 'public')));

        foreach ($data as $key => $d) {
            try{
                $product = Product::where('product_name', $d[0]['product_name'])->firstOrFail(['id','product_name','total_quantity','cost_price']);
                $limit = $d[0]['limit'];
                $data->forget($key);
                $data[] = [
                    'product' => $product,
                    'limit' => $limit,
                    'price_per_unit' => $d[0]['price_per_unit'],
                    'total_piece' => $d[0]['total_piece'],
                    'total_packet' => $d[0]['total_packet'],
                ];
            } catch (ModelNotFoundException) {
                return response()->json([
                    'message' => 'Product '.$d[0]['product_name'].' not found'
                ], 404);
            }
        }

        return response()->json([
            'product' => $data,
        ]);
    }

    public function products(Request $request): JsonResponse
    {
        return response()->json([
            'data' => Product::where('manufacturer_id', Vendor::where('id', $request->vendor_id)->pluck('manufacturer_id')->first())->get(['id', 'product_name']),
            'manufacturer' => Vendor::where('id', $request->vendor_id)->with('manufacturer')->first(),
        ]);
    }

    public function create(): View
    {
        return view('purchase.requistion.create', [
            'requistion_id' => Requistion::latest()->pluck('id')->first(),
            'vendors' => Vendor::orderBy('account_title')->get(['id', 'account_title']),
        ]);
    }

    public function productDetails(Request $request): JsonResponse
    {
        return response()->json([
            'product' => Product::whereIn('id', $request->product_id)->get(),
        ]);
    }

    public function store(RequistionRequest $request): RedirectResponse
    {
        $requistion = Requistion::create([
            'vendor_id' => $request->vendor_id,
            'remarks' => $request->remarks,
            'delivery_date' => $request->delivery_date
        ]);

        foreach ($request->products as $product) {
            RequistionProduct::create([
                'requistion_id' => $requistion->id,
                'product_id' => $product['id'],
                'limit' => $product['limit'],
                'price_per_unit' => $product['price_per_unit'],
                'total_piece' => $product['total_piece'],
                'total_amount' => $product['total_amount'],
            ]);
        }

        return to_route('purchase.requistions.index')->with('success', 'Requistion created!');
    }

    public function show(Requistion $requistion): View
    {
        return view('purchase.requistion.show', [
            'requistion' => $requistion->load('requistionProducts.product'),
        ]);
    }

    public function edit(Requistion $requistion): View
    {
        return view('purchase.requistion.edit', [
            'requistion' => $requistion->load(['requistionProducts.product', 'vendor.manufacturer'])
        ]);
    }

    public function update(RequistionRequest $request, Requistion $requistion): RedirectResponse
    {
        $requistion->update([
            'remarks' => $request->remarks,
            'delivery_date' => $request->delivery_date
        ]);

        $requistion->requistionProducts()->delete();
        foreach ($request->products as $product) {
            RequistionProduct::create([
                'requistion_id' => $requistion->id,
                'product_id' => $product['id'],
                'limit' => $product['limit'],
                'price_per_unit' => $product['price_per_unit'],
                'total_piece' => $product['total_piece'],
                'total_amount' => $product['total_amount'],
            ]);
        }
        return to_route('purchase.requistions.index')->with('success', 'Requistion updated!');
    }

    public function destroy(Requistion $requistion): RedirectResponse
    {
        $requistion->delete();

        return back()->with('success', 'Requistion deleted!');
    }

    public function print(Requistion $requistion): View
    {
        return view('purchase.requistion.print', [
            'requistion' => $requistion->load(['requistionProducts.product.manufacturer', 'vendor']),
            'last_purchase' => GoodReceiveNote::where('requistion_id',$requistion->id)->with('goodReceiveProducts')->latest()->first(),
        ]);
    }
}