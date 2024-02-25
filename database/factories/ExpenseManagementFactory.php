<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExpenseManagement>
 */
class ExpenseManagementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lead_name' => $this->faker->name,
            'activity' => $this->faker->randomElement(['Airtime', 'Accomodation', 'Travel', 'Internet']),
            'status' => $this->faker->randomElement(['pending', 'approved']),
            'notes' => implode(' ', $this->faker->sentences(5)), // Join sentences into a single string.
            'document' => $this->generateFakeFilePath(), // Custom method to generate a fake file path.
            'amount' => $this->faker->numberBetween(10000, 100000),
            'request_date' => $this->faker->date,
        ];
    }

/**
 * Generate a fake file path for the 'document' field.
 *
 * @return string
 */
    protected function generateFakeFilePath(): string
    {
        $directories = ['documents', 'files', 'uploads'];
        $fileName = $this->faker->lexify('??????') . '.' . $this->faker->fileExtension;

        return $this->faker->randomElement($directories) . '/' . $fileName;
    }

}
