<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bank Admin
        $bank_admin = [
            'name' => 'Bank Admin',
            'email' => 'bank_admin@yofinvoice.com',
        ];

        $bank_admin = User::factory()->create($bank_admin);

        $bank_admin->assignRole('bank_admin');

        $bank_admin2 = [
            'name' => 'Bank Admin',
            'email' => 'bank_admin2@yofinvoice.com',
        ];

        $bank_admin = User::factory()->create($bank_admin2);

        $bank_admin->assignRole('bank_admin');

        $bank_user = [
            'name' => 'Bank User',
            'email' => 'bank_user@yofinvoice.com',
        ];

        $bank_user = User::factory()->create($bank_user);

        $bank_user->assignRole('bank_user');

        $company_user = [
            'name' => 'Deveint',
            'email' => 'deveint@yofinvoice.com'
        ];

        $company_user = User::factory()->create($company_user);

        $company_user->assignRole('company_user');
    }
}
