<?php

namespace Database\Seeders;

use App\Models\BankPaymentAccount;
use Database\Factories\BankPaymentAccountFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankPaymentAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BankPaymentAccount::factory()->create([
            'account_name' => 'Advance Discount Account'
        ]);

        BankPaymentAccount::factory()->create([
            'account_name' => 'Fee Income Account'
        ]);
    }
}
