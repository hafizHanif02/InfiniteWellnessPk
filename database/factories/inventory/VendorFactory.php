<?php

namespace Database\Factories\Inventory;

use App\Models\Inventory\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'manufacturer_id' => Manufacturer::pluck('id')->first(),
            'account_title' => 'Phasa',
            'contact_person' => 'Junaid',
            'phone' => 0523525453534,
            'email' => 'vendor@contact.com',
            'address' => 'karachi',
            'ntn' => 432423,
            'sales_tax_reg' => 43424,
            'active' => 1,
            'area' => 'lyari',
            'city' => 'karachi',
        ];
    }
}
