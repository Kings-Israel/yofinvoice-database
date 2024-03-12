<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceFee;
use App\Models\InvoiceItem;
use App\Models\Program;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $program = Program::first();
        $company = Company::where('id', 2)->first();

        Invoice::factory()
                ->has(InvoiceItem::factory(2), 'invoiceItems')
                ->has(InvoiceFee::factory(), 'invoiceFees')
                ->create([
                    'program_id' => $program->id,
                    'company_id' => $company->id
                ]);
    }
}
