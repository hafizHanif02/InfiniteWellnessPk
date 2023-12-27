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
            'invoice_number' => ['required', 'string', 'max:255'],
            'requistion_id' => ['required', 'exists:requistions,id'],
            'remark' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'total_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'net_total_amount' => ['required', 'numeric', 'min:0'],
            'advance_tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'advance_tax_amount' => ['nullable', 'numeric', 'min:0'],
            'sale_tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'products.*' => ['required'],
            'products.*.expiry_date' => ['required', 'date'],
            'products.*.batch_no' => ['required', 'min:0'],
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.deliver_qty' => ['required', 'integer', 'min:0'],
            'products.*.bonus' => ['nullable', 'integer', 'min:0'],
            'products.*.totalprice2' => ['required', 'numeric', 'min:0'],
            'products.*.discount' => ['nullable', 'numeric', 'min:0'],
            'products.*.saletax_percentage' => ['nullable', 'numeric'],
            'products.*.saletax_amount' => ['nullable', 'numeric'],

        ];
    }

    public function messages(): array
    {
        return [
            'requistion_id.required' => 'The requistion field is required',
            'products.*.required' => 'Atleast one product is required',
            'products.*.required' => 'The product field is required',
            'invoice_number.required' => 'The invoice number field is required', 
        ];
    }
}
