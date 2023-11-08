<?php

namespace App\Imports\Inventory;

use App\Models\Log;
use App\Models\Inventory\Generic;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GenericImport implements SkipsEmptyRows, ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'formula' => ['required', 'string', 'max:255', 'unique:generics,formula'],
            'generic_detail' => ['required', 'string'],
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Generic::create([
                'formula' => $row['formula'],
                'generic_detail' => $row['generic_detail'],
            ]);

            $user = Auth::user();
            Log::create([
            'action' => 'Generic Formula Has Been Created Generic Formula: '.$row['formula'],
            'action_by_user_id' => $user->id,
            ]);
        }
    }
}
