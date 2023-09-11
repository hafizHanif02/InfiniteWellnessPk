<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => 'super',
            'last_name' => 'admin',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ];
    }
}
