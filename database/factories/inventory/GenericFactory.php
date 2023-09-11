<?php

namespace Database\Factories\Inventory;

use Illuminate\Database\Eloquent\Factories\Factory;

class GenericFactory extends Factory
{
    public function definition(): array
    {
        return [
            'formula' => 'h2o',
            'generic_detail' => 'water',
        ];
    }
}
