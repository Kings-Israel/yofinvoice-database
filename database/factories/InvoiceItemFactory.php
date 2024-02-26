<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InvoiceItem>
 */
class InvoiceItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $items = ['Oil', 'Bread', 'Flour', 'Water'];

        return [
            'item' => $items[rand(0, count($items) - 1)],
            'quantity' => rand(5, 20),
            'unit' => 'kgs',
            'price_per_quantity' => rand(2, 8)
        ];
    }
}
