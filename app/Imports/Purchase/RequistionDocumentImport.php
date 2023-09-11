<?php

namespace App\Imports\Purchase;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class RequistionDocumentImport implements SkipsEmptyRows, ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'product_name' => ['required', 'string', 'max:255', 'exists:products,product_name'],
            'limit' => ['required', 'string', 'in:unit_quantity,box_quantity'],
            'price_per_unit' => ['required', 'numeric', 'min:0'],
            'total_piece' => ['required', 'integer', 'min:1'],
            'total_packet' => ['required', 'integer', 'min:1'],
        ];
    }

    public function collection(Collection $rows)
    {
        return $rows;
    }
}
