<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'manufacturer_id' => ['required', 'exists:manufacturers,id'],
            'account_title' => ['required', 'string', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255', $this->method() == 'POST' ? 'unique:vendors,contact_person' : ''],
            'phone' => ['required', 'numeric'],
            'email' => ['required', 'string', 'email'],
            'address' => ['required', 'string', 'max:255'],
            'ntn' => ['required', 'integer'],
            'sales_tax_reg' => ['required', 'integer'],
            'active' => ['required', 'integer', 'max:255'],
            'area' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
        ];
    }
}
