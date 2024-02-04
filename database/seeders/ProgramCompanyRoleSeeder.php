<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Program;
use App\Models\ProgramCompanyRole;
use App\Models\ProgramRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramCompanyRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $program = Program::first();
        // Anchor
        $anchor = Company::where('id', 1)->first();
        $anchor_role = ProgramRole::where('name', 'anchor')->first();

        ProgramCompanyRole::create([
            'program_id' => $program->id,
            'company_id' => $anchor->id,
            'role_id' => $anchor_role->id
        ]);

        // Vendor
        $vendor = Company::where('id', 2)->first();
        $vendor_role = ProgramRole::where('name', 'vendor')->first();

        ProgramCompanyRole::create([
            'program_id' => $program->id,
            'company_id' => $vendor->id,
            'role_id' => $vendor_role->id
        ]);
    }
}
