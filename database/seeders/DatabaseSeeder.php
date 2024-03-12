<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(2)->create();

        User::factory()->create([
            'name' => 'Ish',
            'email' => 'ishmael@deveint.ish',
        ]);

        User::factory()->create([
            'name' => 'crm',
            'email' => 'crm@yofinvoice.com',
        ]);
        User::factory()->create([
            'name' => 'Linet',
            'email' => 'linet@deveint.com',
        ]);
        $this->call(OpportunitySeeder::class);
        $this->call(ExpenseManagementSeeder::class);
        $this->call(TransactionSeeder::class);

        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(ProgramRoleSeeder::class);
        $this->call(ProgramTypeSeeder::class);
        $this->call(ProgramCodeSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(BankUserSeeder::class);
        $this->call(ProgramSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ProgramCompanyRoleSeeder::class);
        $this->call(CompanyUserSeeder::class);
        $this->call(PurchaseOrderSeeder::class);
        $this->call(InvoiceSeeder::class);
        $this->call(RoleTypeSeeder::class);
    }
}
