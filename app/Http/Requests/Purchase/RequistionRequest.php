<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class RequistionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => $this->method() == 'POST' ? ['required', 'exists:vendors,id'] : '',
            'remarks' => ['nullable', 'string', 'max:255'],
            'delivery_date' => ['nullable', 'date'],
            'products.*' => ['required'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.limit' => ['required', 'integer', 'min:0'],
            'products.*.price_per_unit' => ['required', 'numeric', 'min:0'],
            'products.*.total_piece' => ['required', 'numeric', 'min:1'],
            'products.*.total_amount' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'vendor_id.required' => 'Select atleast one vendor',
            'products.*.required' => 'Atleast one product is required',
        ];
    }
}