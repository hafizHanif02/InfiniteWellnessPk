<?php

namespace App\Http\Controllers\Shift;

use App\Exports\StockInExport;
use App\Http\Controllers\Controller;
use App\Models\Inventory\StockIn;
use Illuminate\View\View;

class StockReportController extends Controller
{
    public function stockInReport(): View
    {
        return view('shift.stock-out.index', [
            'stockIns' => StockIn::latest()->paginate(now()->daysInMonth)->onEachSide(1),
        ]);
    }

    public function exportStockInReport()
    {
        return (new StockInExport)->download('stock-in-report.xlsx');
    }
}
