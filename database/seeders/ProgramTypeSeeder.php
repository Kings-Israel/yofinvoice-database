<?php

namespace Database\Seeders;

use App\Models\ProgramType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Vendor Financing', 'Dealer Financing'];

        collect($types)->each(fn ($type) => ProgramType::create(['name' => $type]));
    }
}
