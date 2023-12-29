<?php

use App\Http\Controllers\Purchase\GoodReceiveNoteController;
use App\Http\Controllers\Purchase\GoodReceiveStatusController;
use App\Http\Controllers\Purchase\PurchaseOrderController;
use App\Http\Controllers\Purchase\PurchaseOrderListController;
use App\Http\Controllers\Purchase\PurchaseReturnNoteController;
use App\Http\Controllers\Purchase\PurchaseReturnStatusController;
use App\Http\Controllers\Purchase\RequistionController;
use Illuminate\Support\Facades\Route;

Route::prefix('purchase')->as('purchase.')->middleware(['auth'])->group(function () {

    // Requistions
    Route::resource('requistions', RequistionController::class);
    Route::get('requistions/products/list', [RequistionController::class, 'products'])->name('requistions.products');
    Route::post('requistions/product', [RequistionController::class, 'productDetails'])->name('requistions.product.show');
    Route::post('requistions/import-excel', [RequistionController::class, 'importExcel'])->name('requistions.import-excel');
    Route::post('/validate-requistions', [RequistionController::class, 'validateRequistion']);
    Route::post('requistions/document/import', [RequistionController::class, 'importDocument'])->name('requistions.import-document');
    // Purchase Requistion Print
    Route::get('requistions/print/{requistion}', [RequistionController::class, 'print'])->name('requistions.print');

    // Purchase Order
    Route::resource('purchaseorder', PurchaseOrderController::class);
    Route::get('purchaseorder/products/list', [PurchaseOrderController::class, 'products'])->name('purchaseorder.products.list');
    Route::patch('purchaseorder/status/{requistion}', [PurchaseOrderController::class, 'status'])->name('purchaseorder.status');

    // Good Receiveing Note
    Route::resource('good_receive_note', GoodReceiveNoteController::class);

    // Get Requestion From Ajax
    Route::get('/get/requisitions/{vendorId}', [GoodReceiveNoteController::class, 'getRequisitions']);
    Route::get('/get/requistion-products/{requistionId}', [GoodReceiveNoteController::class, 'getRequisitionProducts']);

    // Good Receiving Status
    Route::get('good-receive-statuses', [GoodReceiveStatusController::class, 'index'])->name('good-receive-statuses.index');
    Route::get('good-receive-statuses/{goodReceiveNote}', [GoodReceiveStatusController::class, 'show'])->name('good-receive-statuses.show');
    Route::patch('good-receive-statuses/{goodReceiveNote}', [GoodReceiveStatusController::class, 'status'])->name('good-receive-statuses.status');



    // Validation Route
    Route::post('/validate-goodreceivenote', [GoodReceiveNoteController::class, 'validateGoodReceiveNote']);

    Route::resource('purchaseorderlist', PurchaseOrderListController::class);
    Route::get('purchase-order-list/filter', [PurchaseOrderListController::class, 'filter'])->name('purchaseorder.list.filter');

    // Purchase Purchase Order Print
    Route::get('purchase-order-list/print/{requistionId}', [PurchaseOrderListController::class, 'print'])->name('purchase-order-list.print');

    // Purchase return
    Route::resource('return', PurchaseReturnNoteController::class);
    Route::get('purchase-return/{goodReceiveNoteId}/product-list', [PurchaseReturnNoteController::class, 'returnProductList']);

    // Purchase return status
    Route::resource('purchase-return-status', PurchaseReturnStatusController::class);
    Route::get('purchase-return-status/retransfer/{purchasereturn}',[ PurchaseReturnStatusController::class,'retransfer'])->name('purchase-return-status.retransfer');

    // Purchase GRN Print
    Route::get('good_receive_note/print/{id}', [GoodReceiveNoteController::class, 'print'])->name('good_receive_note.print');
    Route::get('grnExport', [GoodReceiveNoteController::class, 'grnExport'])->name('grnExport');

});
