<?php

namespace Database\Factories\Inventory;

use Illuminate\Database\Eloquent\Factories\Factory;

class ManufacturerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_name' => 'Pfizer'
        ];
    }
}
