<?php

use App\Http\Controllers\Shift\StockReportController;
use App\Http\Controllers\Shift\TransferController;
use Illuminate\Support\Facades\Route;

Route::prefix('shift')->as('shift.')->middleware(['auth'])->group(function () {
    // Transfer
    Route::resource('transfers', TransferController::class);
    Route::post('import-excel', [TransferController::class, 'importExcel'])->name('import-excel');

    Route::get('transfer-products/{product}', [TransferController::class, 'products'])->name('transfers.products');
    Route::get('transfer-report-print', [TransferController::class, 'printReport'])->name('transfers.export');

    //Stock In
    Route::get('stock-in', [StockReportController::class, 'stockInReport'])->name('stock-in.index');
    Route::get('stock-in/export', [StockReportController::class, 'exportStockInReport'])->name('stock-in.export');

    Route::post('/validate-transfer', [TransferController::class, 'validateTransfer']);
    
    Route::get('/table_data', [TransferController::class, 'fileData']);

    Route::get('/get-batch/{batchID}', [TransferController::class, 'getBatch'])->name('transfer.batch');


});
