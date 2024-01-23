<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company();

        $cities = ['Nairobi', 'Mombasa', 'Kisumu'];

        return [
            'name' => $name,
            'unique_identification_number' => rand(1000000, 9999999),
            'branch_code' => $name.'-'.time().'-'.rand(1111, 9999),
            'business_identification_number' => mt_rand(1000000, 9999999),
            'organization_type' => 'Marketer',
            'business_segment' => 'Tech Marketing',
            'customer_type' => 'Businesses',
            'kra_pin' => Str::random(11),
            'city' => $cities[rand(0, 2)],
            'postal_code' => '234234 00100',
            'address' => 'Westlands Office Park, Waiyaki Way',
            'relationship_manager_name' => fake()->name(),
            'relationship_manager_email' => fake()->safeEmail(),
            'relationship_manager_phone_number' => fake()->phoneNumber(),
        ];
    }
}
