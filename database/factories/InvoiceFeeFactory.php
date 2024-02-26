<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceFee>
 */
class InvoiceFeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fees = ['Withholding Tax', 'Credit Note'];

        return [
            'name' => $fees[rand(0, 1)],
            'amount' => rand(1000, 9999)
        ];
    }
}
