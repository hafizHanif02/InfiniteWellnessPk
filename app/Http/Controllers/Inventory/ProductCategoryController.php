<?php

namespace App\Http\Controllers\Inventory;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        ProductCategory::create($request->validated());

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

        return to_route('inventory.product-categories.index')->with('success', 'Product category updated!');
    }

    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->delete();

        return back()->with('success', 'product category deleted!');
    }
}
