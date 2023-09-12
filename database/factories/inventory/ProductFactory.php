<?php

namespace Database\Factories\Inventory;

use App\Models\Inventory\Dosage;
use App\Models\Inventory\Generic;
use App\Models\Inventory\Manufacturer;
use App\Models\Inventory\ProductCategory;
use App\Models\Inventory\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_name' => 'Panadol',
            'product_category_id' => ProductCategory::factory(),
            'dosage_id' => Dosage::factory(),
            'generic_id' => Generic::factory(),
            'package_detail' => 'Handle with care',
            'manufacturer_id' => Manufacturer::factory(),
            'vendor_id' => Vendor::factory(),
            'unit_of_measurement' => 0,
            'manufacturer_retail_price' => 1000,
            'number_of_pack' => 10,
            'pieces_per_pack' => 10,
            'total_quantity' => 100,
            'open_quantity' => 100,
            'trade_price_percentage' => 15,
            'unit_retail' => 10,
            'fixed_discount' => 7,
            'trade_price' => 850,
            'unit_trade' => 8.5,
            'sale_tax_percentage' => 7,
            'discount_trade_price' => 2,
            'cost_price' => 833,
            'barcode' => 1001110111,
        ];
    }
}
