<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\BankDocument;
use App\Models\BankPaymentAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bank::factory()
            ->has(BankDocument::factory(3), 'requiredDocuments')
            ->has(BankPaymentAccount::factory())
            ->create();

        sleep(1);

        Bank::factory()
            ->has(BankDocument::factory(2), 'requiredDocuments')
            ->has(BankPaymentAccount::factory())
            ->create([
                'url' => '456789'
            ]);
    }
}
