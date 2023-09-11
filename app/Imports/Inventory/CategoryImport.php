<?php

namespace App\Imports\Inventory;

use App\Models\Inventory\ProductCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CategoryImport implements SkipsEmptyRows, ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:product_categories,name'],
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            ProductCategory::create([
                'name' => $row['name'],
            ]);
        }
    }
}
