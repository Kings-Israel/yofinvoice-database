<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyTestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'bank_id' => $this->faker->numberBetween(1, 2),
            'name' => $this->faker->company,
            'unique_identification_number' => $this->faker->uuid,
            'branch_code' => $this->faker->word,
            'business_identification_number' => $this->faker->swiftBicNumber,
            'organization_type' => $this->faker->randomElement(['Private', 'Public', 'Government']),
            'business_segment' => $this->faker->randomElement(['Finance', 'IT', 'Healthcare']),
            'customer_type' => $this->faker->randomElement(['Retail', 'Corporate', 'Individual']),
            'kra_pin' => $this->faker->numerify('KP#####'),
            'cust_ancode' => $this->faker->lexify('CA???'),
            'logo' => $this->faker->imageUrl(),
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'address' => $this->faker->address,
            'approval_status' => $this->faker->randomElement(['Approved', 'Pending', 'Rejected']),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
            'relationship_manager_name' => $this->faker->name,
            'relationship_manager_email' => $this->faker->companyEmail,
            'relationship_manager_phone_number' => $this->faker->phoneNumber,
            'created_at' => $this->faker->date,
            'updated_at' => $this->faker->date,
            'pipeline_id' => $this->faker->unique()->numberBetween(1, 100),
            'top_level_borrower_limit' => $this->faker->numberBetween(100000, 1000000),
            'limit_expiry_date' => $this->faker->date,
            'is_current' => $this->faker->boolean,
            'is_published' => $this->faker->boolean,
            'published_at' => $this->faker->dateTimeThisYear,
            'uuid' => $this->faker->uuid,
            'publisher_type' => $this->faker->randomElement(['Type A', 'Type B', 'Type C']),
            'publisher_id' => $this->faker->numberBetween(1, 100),
        ];

    }
}
