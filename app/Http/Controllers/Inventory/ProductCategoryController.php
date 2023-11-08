<?php

namespace App\Http\Controllers\Inventory;

use App\Models\Log;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;
use App\Imports\Inventory\CategoryImport;
use App\Models\Inventory\ProductCategory;
use App\Http\Requests\Inventory\ProductCategoryRequest;

class ProductCategoryController extends Controller
{
    public function index(): View
    {
        return view('inventory.product-categories.index', [
            'productCategories' => ProductCategory::latest()->paginate(10)->onEachSide(1),
        ]);
    }

    public function importExcel(Request $request): RedirectResponse
    {
        $request->validate([
            'product_categories_csv' => ['required','file'],
        ]);
        Excel::import(new CategoryImport, storage_path('app/public/'.request()->file('product_categories_csv')->store('product-categories-excel-files', 'public')));

        return back()->with('success', 'Imported successfully!');
    }

    public function create(): View
    {

        return view('inventory.product-categories.create');
    }

    public function store(ProductCategoryRequest $request): RedirectResponse
    { 
        $product =ProductCategory::create($request->validated());
         $user = Auth::user();
            Log::create([
            'action' => 'Product Category Has Been Created Product Name: '.$product->name.' ID('.$product->id.')',
            'action_by_user_id' => $user->id,
        ]);
        return to_route('inventory.product-categories.index')->with('success', 'Product category created!');
    }

    public function edit(ProductCategory $productCategory): View
    {
        return view('inventory.product-categories.edit', [
            'productCategory' => $productCategory,
        ]);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->update($request->validated());
        $user = Auth::user();
        Log::create([
        'action' => 'Product Category Has Been Updated Product Name: '.$productCategory->name.' ID('.$productCategory->id.')',
        'action_by_user_id' => $user->id,
    ]);
        return to_route('inventory.product-categories.index')->with('success', 'Product category updated!');
    }

    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        $user = Auth::user();
        Log::create([
        'action' => 'Product Category Has Been Deleted Product Name: '.$productCategory->name. ' ID('.$productCategory->id.')',
        'action_by_user_id' => $user->id,
    ]);
        $productCategory->delete();

        return back()->with('success', 'product category deleted!');
    }
}
