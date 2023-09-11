<?php

namespace App\Exports;

use App\Models\Shift\Transfer;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TransferExport implements FromCollection, WithEvents, WithHeadings, WithMapping
{
    use Exportable;

    public function headings(): array
    {
        return [
            'Code',
            'Total Price Amount',
            'Total Supply Quantity',
            'Status',
            'Supply Date',
        ];
    }

    public function map($transfer): array
    {
        return [
            $transfer->id,
            $transfer->total_price_amount,
            $transfer->total_supply_quantity,
            ($transfer->status == 0 ? 'Rejected' : 'Approved'),
            $transfer->created_at->format('d M Y'),
        ];
    }

    public function collection()
    {
        return Transfer::with(['transferProducts'])->get();
    }

    public function columnWidths(): array
    {
        return [
            'A' => 200,
            'B' => 200,
            'C' => 200,
            'D' => 200,
            'E' => 200,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Styling the header row
                $event->sheet->getStyle('A1:E1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '000000'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Center align text in all cells
                $event->sheet->getStyle('A2:D'.(Transfer::count() + 1))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}
