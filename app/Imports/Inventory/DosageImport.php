<?php

namespace App\Imports\Inventory;

use App\Models\Log;
use App\Models\Inventory\Dosage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
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
            $dosage = Dosage::create([
                'name' => $row['name'],
            ]);


            $user = Auth::user();
            Log::create([
            'action' => 'Dosage Form Has Been Created Dosage Form Name:'.$row['name'].' Code:('.$dosage->id.')',
            'action_by_user_id' => $user->id,
        ]);
        }
    }
}
