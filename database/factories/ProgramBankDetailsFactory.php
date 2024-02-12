<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramBankDetails>
 */
class ProgramBankDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_as_per_bank' => fake()->name(),
            'account_number' => rand(10000000, 999999999),
            'bank_name' => fake()->company(),
            'branch' => fake()->name(),
            'swift_code' => Str::random(9),
            'account_type' => NULL,
            'status' => 'active'
        ];
    }
}
