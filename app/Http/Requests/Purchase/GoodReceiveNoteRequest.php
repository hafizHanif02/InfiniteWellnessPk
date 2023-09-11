<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class GoodReceiveNoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'date' => now(),
        ]);
    }

    public function rules(): array
    {
        return [
            'requistion_id' => ['required', 'exists:requistions,id'],
            'remark' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'total_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'net_total_amount' => ['required', 'numeric', 'min:0'],
            'advance_tax_percentage' => ['nullable', 'integer', 'min:0'],
            'sale_tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'products.0' => ['required'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.deliver_qty' => ['required', 'integer', 'min:0'],
            'products.*.bonus' => ['nullable', 'integer', 'min:0'],
            'products.*.expiry_date' => ['required', 'date'],
            'products.*.totalprice2' => ['required', 'numeric', 'min:0'],
            'products.*.batch_no' => ['required', 'integer', 'min:0'],
            'products.*.discount' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'requistion_id.required' => 'The requistion field is required',
            'products.0.required' => 'Atleast one product is required',
            'products.*.required' => 'The product field is required',
        ];
    }
}
