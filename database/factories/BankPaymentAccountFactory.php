<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BankPaymentAccount>
 */
class BankPaymentAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_name' => 'Fee Income Account',
            'account_number' => Str::random(3).'_'.Str::random(4).'_'.rand(100, 999)
        ];
    }
}
