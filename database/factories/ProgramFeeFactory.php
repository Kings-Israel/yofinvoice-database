<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramFee>
 */
class ProgramFeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fee_name' => 'VAT',
            'type' => 'percentage',
            'value' => 3,
            'anchor_bearing_discount' => 0,
            'vendor_bearing_discount' => 3,
            'taxes' => 'VAT(16%)',
        ];
    }
}
