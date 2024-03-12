<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bank>
 */
class BankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = ['KCB', 'Equity', 'Ecobank', 'Cooperative'];

        $bank_emails = ['kings@deveint.com', 'linet@deveint.com', 'barry.osewe@yofinvoice.com', 'anthony.macharia@yofinvoice.com', 'ishmael@deveint.com', 'james.mugwe@yopesa.com'];

        return [
            'name' => $name[rand(0, 3)],
            'email' => $bank_emails[rand(0, 5)],
            'url' => '123456'
        ];
    }
}
