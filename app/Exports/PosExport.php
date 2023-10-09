<?php

namespace App\Exports;

namespace App\Exports;

use App\Models\Pos;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PosExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'POS No.',
            'POS Date',
            'Patient Name',
            'Patient Number',
            'Patient MR Number',
            'Doctor Name',
            'Cashier Name',
            'Paid',
            'is_cash',   
            'enter_payment_amount',
            'pos_fees',
            'total_amount',
            'total_discount',
            'total_saletax',
            'total_amount_ex_saletax',
            'total_amount_inc_saletax',
            'change_amount'
        ];
    }

    public function collection()
    {
        // Fetch the data you want to export here
        // For example, if you want to export 'pos_date' and 'total_amount':
        return Pos::select('pos_date', 'total_amount')->get();
    }
}