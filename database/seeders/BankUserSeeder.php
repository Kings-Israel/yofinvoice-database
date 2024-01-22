<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\BankUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = Bank::all();

        foreach ($banks as $bank) {
            $bank_admin = User::role('bank_admin')->first();

            BankUser::create([
                'user_id' => $bank_admin->id,
                'bank_id' => $bank->id
            ]);

            $bank_user = User::role('bank_admin')->first();

            BankUser::create([
                'user_id' => $bank_user->id,
                'bank_id' => $bank->id
            ]);
        }
    }
}
