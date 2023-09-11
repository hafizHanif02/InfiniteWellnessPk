<?php

namespace App\Imports\Inventory;

use App\Models\Inventory\Manufacturer;
use App\Models\Inventory\Vendor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class VendorImport implements SkipsEmptyRows, ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'manufacturer' => ['required', 'exists:manufacturers,company_name', 'max:255'],
            'account_title' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255', 'unique:vendors,contact_person'],
            'phone' => ['required', 'numeric', 'digits:11'],
            'email' => ['required', 'string', 'email'],
            'address' => ['required', 'string', 'max:255'],
            'ntn' => ['required', 'integer', 'digits:7'],
            'sales_tax_reg' => ['required', 'integer', 'digits:13'],
            'active' => ['required', 'string', 'in:yes,no'],
            'area' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Vendor::create([
                'manufacturer_id' => Manufacturer::where('company_name', $row['manufacturer'])->pluck('id')->first(),
                'account_title' => $row['account_title'],
                'contact_person' => $row['contact_person'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'address' => $row['address'],
                'ntn' => $row['ntn'],
                'sales_tax_reg' => $row['sales_tax_reg'],
                'active' => $row['active'] == 'yes' ? 1 : 0,
                'area' => $row['area'],
                'city' => $row['city'],
            ]);
        }
    }
}
