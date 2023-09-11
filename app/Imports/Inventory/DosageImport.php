<?php

namespace App\Imports\Inventory;

use App\Models\Inventory\Dosage;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DosageImport implements SkipsEmptyRows, ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:dosages,name'],
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Dosage::create([
                'name' => $row['name'],
            ]);
        }
    }
}
