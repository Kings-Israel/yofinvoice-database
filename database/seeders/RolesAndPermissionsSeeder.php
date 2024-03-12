<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'bank_admin', 'bank_user', 'anchor', 'vendor', 'company_user'];

        collect($roles)->each(fn ($role) => Role::firstOrCreate(['name' => $role]));
    }
}
