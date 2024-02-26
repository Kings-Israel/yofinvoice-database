<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Opportunity>
 */
class OpportunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stage' => $this->faker->randomElement([
                'Lead',
                'Opportunity',
                'Cold',
                'Reject',
            ]),
            'source' => $this->faker->randomElement([
                'Email',
                'Marketing',
                'Outdoor',
                'LinkedIn',
                'Messages',
                'Google',
                'Adverts',
            ]),
            'company' => $this->faker->company,
            'contact_name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'region' => $this->faker->randomElement([
                "ICT",
                "Healthcare",
                "Finance and Banking",
                "Retail",
                "Manufacturing",
                "Education",
                "Transportation and Logistics",
                "Energy and Utilities",
                "Hospitality and Tourism",
                "Agriculture",
            ]),
            'status' => $this->faker->randomElement([
                "Initiation",
                "Pending",
                "Completed",
            ]),
        ];
    }
}
