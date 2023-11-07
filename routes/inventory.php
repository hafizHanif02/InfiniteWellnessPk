<?php

use App\Models\Inventory\Product;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\Input;
use App\Http\Controllers\Inventory\DosageController;
use App\Http\Controllers\Inventory\VendorController;
use App\Http\Controllers\Inventory\GenericController;
use App\Http\Controllers\Inventory\ProductController;
use App\Http\Controllers\Inventory\ManufacturerController;
use App\Http\Controllers\Inventory\ProductCategoryController;

Route::prefix('inventory')->as('inventory.')->middleware(['auth'])->group(function () {

    // Products
    Route::resource('products', ProductController::class);
    Route::get('/export-to-excel', [ProductController::class,'exportToExcel'])->name('export-to-excel')->middleware('web');

    // Route::post('/export-to-excel', [ProductController::class,'exportToExcel'])->name('export.to.excel');
    Route::post('products/product-categories/store', [ProductController::class, 'storeProductCategory'])->name('products.product-categories.store');
    Route::post('products/dosage/store', [ProductController::class, 'storeDosage'])->name('products.dosages.store');
    Route::post('products/manufactures/store', [ProductController::class, 'storeManufacturer'])->name('products.manufacturers.store');
    Route::post('products/generics/store', [ProductController::class, 'storeGeneric'])->name('products.generics.store');
    Route::get('/form', [ProductController::class, 'form'])->name('form');
    Route::get('/form/opd/list', [ProductController::class, 'opd'])->name('opd');
    Route::post('products/vendors/store', [ProductController::class, 'storeVendor'])->name('products.vendors.store');
    Route::post('products/import-excel', [ProductController::class, 'importExcel'])->name('products.import-excel');
    Route::get('report_products', [ProductController::class, 'productsReport'])->name('products.products_report');
    // Route::get('report_products/print', [ProductController::class, 'productsReportPrint'])->name('products_report.print');


    // Product Categories
    Route::resource('product-categories', ProductCategoryController::class)->except('show');
    Route::post('product-categories/import-excel', [ProductCategoryController::class, 'importExcel'])->name('product-categories.import-excel');

    // Dosages/
    Route::resource('dosages', DosageController::class)->except('show');
    Route::post('dosages/import-excel', [DosageController::class, 'importExcel'])->name('dosages.import-excel');

    // Manufacturers
    Route::resource('manufacturers', ManufacturerController::class);
    Route::post('manufacturers/import-excel', [ManufacturerController::class, 'importExcel'])->name('manufacturers.import-excel');

    // Generics
    Route::resource('generics', GenericController::class);
    Route::post('generics/import-excel', [GenericController::class, 'importExcel'])->name('generics.import-excel');

    // Vendors
    Route::resource('vendors', VendorController::class);
    Route::post('vendors/import-excel', [VendorController::class, 'importExcel'])->name('vendors.import-excel');

    Route::get('recalculation', [ProductController::class, 'recalculation'])->name('recalculation');
    Route::post('recalculation', [ProductController::class, 'recalculate'])->name('recalculate');
    Route::get('adjustment', [ProductController::class, 'adjustment'])->name('products.adjustment');
    Route::get('adjustment/create', [ProductController::class, 'adjustmentCreate'])->name('products.adjustment.create');
    Route::post('adjustment/store', [ProductController::class, 'adjustmentStore'])->name('adjustments.store');

});
