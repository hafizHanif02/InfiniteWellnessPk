<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StockInRequest extends FormRequest
{
    public function authorize()
    {
        return [
            'group_id' => ['required', 'exists:groups,id'],
            'product_name' => ['required', 'string', 'max:255'],
            'manufacturer_id' => ['required', 'exists:manufacturers,id'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'generic_id' => ['required', 'exists:generics,id'],
            'package_detail' => ['nullable', 'string', 'max:255'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'least_unit' => ['required', 'integer', 'in:0,1'],
            'manufacturer_retail_price' => ['required', 'integer'],
            'pieces_per_pack' => ['required', 'integer'],
            'number_of_pack' => ['nullable', 'integer'],
            'packing' => ['required', 'integer'],
            'trade_price_percentage' => ['required', 'integer'],
            'unit_retail' => ['required', 'numeric'],
            'fixed_discount' => ['nullable', 'numeric'],
            'trade_price' => ['required', 'numeric'],
            'unit_trade' => ['required', 'numeric'],
            'sale_tax' => ['nullable', 'numeric'],
            'discount_trade_price' => ['nullable', 'numeric'],
            'cost_price' => ['required', 'numeric'],
            'barcode' => ['nullable', 'numeric'],
        ];
    }

    public function rules()
    {
        return [
            'group_id.required' => 'The group field is required',
            'generic_id.required' => 'The generic field is required',
            'product_category_id.required' => 'The category field is required',
            'manufacturer_id.required' => 'The manufacturer field is required',
            'vendor_id.required' => 'The vendor field is required',
        ];
    }
}
