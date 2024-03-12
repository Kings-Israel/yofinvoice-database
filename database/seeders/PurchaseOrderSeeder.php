<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\PurchaseOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::where('id', 2)->first();

        PurchaseOrder::factory(5)->create(['company_id' => $company->id]);
    }
}
