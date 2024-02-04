<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Program;
use App\Models\ProgramCode;
use App\Models\ProgramType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bank = Bank::first();
        $program_type = ProgramType::where('name', 'Vendor Financing')->first();
        $program_code = ProgramCode::first();

        Program::factory()->create([
            'bank_id' => $bank->id,
            'program_type_id' => $program_type->id,
            'program_code_id' => $program_code->id,
        ]);
    }
}
