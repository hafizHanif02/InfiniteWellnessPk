<?php

namespace App\Imports\Inventory;

use App\Models\Log;
use App\Models\Inventory\Dosage;
use App\Models\Inventory\Vendor;
use App\Models\Inventory\Generic;
use App\Models\Inventory\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory\Manufacturer;
use App\Models\Inventory\ProductCategory;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductImport implements SkipsEmptyRows, ToCollection, WithHeadingRow, WithValidation
{
    public function rules(): array
    {
        return [
            'product_name' => ['required', 'string', 'max:255', 'unique:products,product_name'],
            'dosage' => ['required', 'exists:dosages,name', 'max:255'],
            'generic_formula' => ['required', 'exists:generics,formula'],
            'package_detail' => ['nullable', 'string', 'max:255'],
            'product_category' => ['required', 'exists:product_categories,name', 'max:255'],
            'manufacturer' => ['required', 'exists:manufacturers,company_name', 'max:255'],
            // 'vendor' => ['required', 'exists:vendors,contact_person', 'max:255'],
            'unit_of_measurement' => ['required', 'in:unit_quantity,box_quantity'],
            'manufacturer_retail_price' => ['required', 'numeric', 'min:0'],
            'pieces_per_pack' => ['required', 'integer', 'min:0'],
            'number_of_pack' => ['nullable', 'integer', 'min:0'],
            'trade_price_percentage' => ['required', 'numeric', 'min:0'],
            'fixed_discount' => ['nullable', 'numeric', 'min:0'],
            'sale_tax_percentage' => ['nullable', 'numeric', 'min:0'],
            'discount_trade_price' => ['nullable', 'numeric', 'min:0'],
            // 'barcode' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $product = Product::create([
                'product_name' => $row['product_name'],
                'dosage_id' => Dosage::where('name', $row['dosage'])->pluck('id')->first(),
                'generic_id' => Generic::where('formula', $row['generic_formula'])->pluck('id')->first(),
                'package_detail' => $row['package_detail'] ?? null,
                'product_category_id' => ProductCategory::where('name', $row['product_category'])->pluck('id')->first(),
                'manufacturer_id' => Manufacturer::where('company_name', $row['manufacturer'])->pluck('id')->first(),
                // 'vendor_id' => Vendor::where('contact_person', $row['vendor'])->pluck('id')->first(),
                'unit_of_measurement' => $row['unit_of_measurement'] == 'unit_quantity' ? 1 : 0,
                'manufacturer_retail_price' => $row['manufacturer_retail_price'],
                'number_of_pack' => $row['unit_of_measurement'] == 'unit_quantity' ? 1 : $row['number_of_pack'],
                'pieces_per_pack' => $row['pieces_per_pack'],
                'total_quantity' => 0,
                'trade_price_percentage' => $row['trade_price_percentage'],
                'unit_retail' => $row['number_of_pack'] * $row['pieces_per_pack'],
                'fixed_discount' => $row['fixed_discount'] ?? 0,
                'trade_price' => $row['manufacturer_retail_price'] - ($row['manufacturer_retail_price'] * $row['trade_price_percentage'] / 100),
                'unit_trade' => 0,
                'sale_tax_percentage' => $row['sale_tax_percentage'] ?? 0,
                'discount_trade_price' => $row['discount_trade_price'] ?? 0,
                'cost_price' => 0,
                'barcode' => $row['barcode'] ?? null,
            ]);

            
            $product->update([
                'product_name' => $row['product_name'],
                'dosage_id' => Dosage::where('name', $row['dosage'])->pluck('id')->first(),
                'generic_id' => Generic::where('formula', $row['generic_formula'])->pluck('id')->first(),
                'package_detail' => $row['package_detail'] ?? null,
                'product_category_id' => ProductCategory::where('name', $row['product_category'])->pluck('id')->first(),
                'manufacturer_id' => Manufacturer::where('company_name', $row['manufacturer'])->pluck('id')->first(),
                'unit_of_measurement' => $row['unit_of_measurement'] == 'unit_quantity' ? 1 : 0,
                'manufacturer_retail_price' => $row['manufacturer_retail_price'],
                'number_of_pack' => $row['unit_of_measurement'] == 'unit_quantity' ? 1 : $row['number_of_pack'],
                'pieces_per_pack' => $row['pieces_per_pack'],
                'trade_price_percentage' => $row['trade_price_percentage'],
                'unit_retail' => $row['number_of_pack'] * $row['pieces_per_pack'],
                'fixed_discount' => $row['fixed_discount'] ?? 0,
                'trade_price' => $row['manufacturer_retail_price'] - ($row['manufacturer_retail_price'] * $row['trade_price_percentage'] / 100),
                'sale_tax_percentage' => $row['sale_tax_percentage'] ?? 0,
                'discount_trade_price' => $row['discount_trade_price'] ?? 0,
                'barcode' => $row['barcode'] ?? null,
            ]);
            $user = Auth::user();
            Log::create([
                'action' => 'Product Has Been Created Product Name: '.$row['product_name'].' ('.$product->id.')',
                'action_by_user_id' => $user->id,
            ]);
        }
    }
}
