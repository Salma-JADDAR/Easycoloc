<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'), 
            'role' => fake()->randomElement(['user', 'admin']),
            'reputation' => fake()->numberBetween(0, 100),
            'banned_at' => fake()->optional(0.1)->dateTime(), 
        ];
    }
}
