<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Company;
use App\Models\Program;
use App\Models\ProgramAnchorDetails;
use App\Models\ProgramBankDetails;
use App\Models\ProgramBankUserDetails;
use App\Models\ProgramCode;
use App\Models\ProgramCompanyRole;
use App\Models\ProgramDiscount;
use App\Models\ProgramFee;
use App\Models\ProgramRole;
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
        $program_code = ProgramCode::where('name', 'Vendor Financing Receivable')->first();
        $anchor_role = ProgramRole::where('name', 'anchor')->first();

        $program = Program::factory()
                ->has(ProgramDiscount::factory(), 'discountDetails')
                ->has(ProgramFee::factory(), 'fees')
                ->has(ProgramBankUserDetails::factory(), 'bankUserDetails')
                ->has(ProgramBankDetails::factory(), 'bankDetails')
                ->create([
                    'bank_id' => $bank->id,
                    'program_type_id' => $program_type->id,
                    'program_code_id' => $program_code->id,
                ]);
    }
}
