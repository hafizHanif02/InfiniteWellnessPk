<?php

namespace Database\Factories\Inventory;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'medicine',
        ];
    }
}
