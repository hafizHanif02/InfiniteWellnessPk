<?php

namespace App\Imports\Inventory;

use App\Models\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory\ProductCategory;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
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

        $user = Auth::user();
        Log::create([
            'action' => 'Product Category Has Been Created Category Name: '.$row['name'],
            'action_by_user_id' => $user->id,
        ]);
        }
    }
}
