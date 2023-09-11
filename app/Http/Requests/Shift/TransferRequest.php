<?php

namespace App\Http\Requests\Shift;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supply_date' => ['required', 'date'],
            'products.0' => ['required'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.unit_of_measurement' => ['required', 'integer', 'in:0,1'],
            'products.*.price_per_unit' => ['required', 'numeric', 'min:1'],
            'products.*.total_piece' => ['required', 'integer', 'min:1'],
            'products.*.total_pack' => ['required', 'integer', 'min:1'],
            'products.*.amount' => ['required', 'numeric', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'products.0.required' => ['Atleast one product is required'],
        ];
    }
}
