<?php

namespace App\Exports;

use App\Models\Vaccination;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class VaccinationExport implements FromView, ShouldAutoSize, WithEvents, WithTitle
{
    public function view(): View
    {
        return view('exports.vaccinations', ['vaccinations' => Vaccination::all()]);
    }

    public function title(): string
    {
        return 'vaccinations';
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
