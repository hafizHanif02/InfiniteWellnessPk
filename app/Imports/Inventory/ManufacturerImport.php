<?php

namespace App\Imports\Inventory;

use App\Models\Log;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory\Manufacturer;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ManufacturerImport implements SkipsEmptyRows, ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255', 'unique:manufacturers,company_name'],
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Manufacturer::create([
                'company_name' => $row['company_name'],
            ]);
        
        $user = Auth::user();
        Log::create([
            'action' => 'Manufacturer Has Been Created Company Name: '.$row['company_name'],
            'action_by_user_id' => $user->id,
        ]);

        }
    }
}
