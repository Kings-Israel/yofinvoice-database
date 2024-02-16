<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramDiscount>
 */
class ProgramDiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'benchmark_title' => 'Bench Rate 1',
            'benchmark_rate' => 5,
            'reset_frequency' => 'Monthly',
            'days_frequency_days' => 30,
            'business_strategy_spread' => 4,
            'credit_spread' => 2,
            'total_spread' => 6,
            'total_roi' => 8,
            'anchor_discount_bearing' => 0,
            'vendor_discount_bearing' => 8,
            'discount_type' => 'Rear Ended',
            'penal_discount_on_principle' => 2,
            'anchor_fee_recovery' => 'Beginning of Tenor',
            'grace_period' => 5,
            'grace_period_discount' => 2,
            'maturity_handling_on_holidays' => 'No Effect',
        ];
    }
}
