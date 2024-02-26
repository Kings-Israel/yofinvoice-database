<?php

namespace Database\Seeders;

use App\Models\ExpenseManagement;
use Illuminate\Database\Seeder;

class ExpenseManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpenseManagement::factory()->count(5)->create();
    }
}
