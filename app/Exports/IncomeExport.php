<?php

namespace App\Exports;

use App\Models\Income;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class IncomeExport implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public function view(): View
    {
        $incomeHead = Income::INCOME_HEAD;

        return view('exports.incomes', ['incomes' => Income::all(), 'incomeHead' => $incomeHead]);
    }

    public function title(): string
    {
        return 'Incomes';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
