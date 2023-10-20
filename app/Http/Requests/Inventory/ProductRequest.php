<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // public function prepareForValidation(): void
    // {
    //     $this->trade_price = $this->manufacturer_retail_price - ($this->manufacturer_retail_price * $this->trade_price_percentage / 100);
    //     $this->unit_retail = $this->number_of_pack * $this->pieces_per_pack;
    //     $this->unit_trade = $this->trade_price / ($this->pieces_per_pack * $this->number_of_pack);
    //     $this->cost_price = $this->trade_price - ($this->trade_price * $this->discount_trade_price / 100);
    //     $this->total_quantity = $this->number_of_pack * $this->pieces_per_pack;
    // }

    public function rules(): array
    {
        return [
            'dosage_id' => ['required', 'exists:dosages,id'],
            'product_name' => ['required', 'string', 'max:255', $this->method() == 'POST' ? 'unique:products,product_name' : ''],
            'manufacturer_id' => ['required', 'exists:manufacturers,id'],
            'vendor_id' => ['nullable', 'exists:vendors,id'],
            'generic_id' => ['required', 'exists:generics,id'],
            'package_detail' => ['nullable', 'string', 'max:255'],
            'dricetion_of_use' => ['nullable', 'string', 'max:255'],
            'common_side_effect' => ['nullable', 'string', 'max:255'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'unit_of_measurement' => ['required', 'integer', 'in:0,1'],
            'manufacturer_retail_price' => ['required', 'numeric', 'min:0'],
            'pieces_per_pack' => ['required', 'integer', 'min:0'],
            'number_of_pack' => ['nullable', 'integer', 'min:0'],
            // 'total_quantity' => ['required', 'integer', 'min:1'],
            'trade_price_percentage' => ['required', 'numeric', 'min:0'],
            'unit_retail' => ['required', 'numeric', 'min:0'],
            'fixed_discount' => ['nullable', 'numeric', 'min:0'],
            'trade_price' => ['required', 'numeric', 'min:0'],
            'unit_trade' => ['required', 'numeric', 'min:0'],
            'sale_tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'discount_trade_price' => ['nullable', 'numeric', 'min:0'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'barcode' => ['nullable', 'string', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'dosage_id.required' => 'The dosage field is required',
            'generic_id.required' => 'The generic field is required',
            'product_category_id.required' => 'The product category field is required',
            'manufacturer_id.required' => 'The manufacturer field is required',
            'vendor_id.required' => 'The vendor field is required',
        ];
    }
}
