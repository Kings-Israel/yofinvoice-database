<?php

namespace Database\Seeders;

use App\Models\RoleType;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = asset('json/permission.json');
        $permissions = json_decode($json, true);

        foreach ($permissions['permissions'] as $permission) {
            $roleType = RoleType::create(['name' => $permission['type']]);

            foreach ($permission['groups'] as $group) {
                $roleGroup = $roleType->Groups()->create(['name' => $group['name']]);

                foreach ($group['roles'] as $roleName) {
                    $roleGroup->AccessGroups()->create(['name' => $roleName]);
                }
            }
        }
    }
}
