<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'good_receive_note_id' => ['required', 'exists:good_receive_notes,id'],
            'products' => 'required',
            'products.*.id' => ['required', 'exists:products,id'],
            'products.*.quantity' => ['required', 'integer', 'min:0'],
            'products.*.price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'good_receive_note_id.required' => 'The good receive note field is required',
            'products.0.required' => 'Atleast one product is required',
        ];
    }
}
