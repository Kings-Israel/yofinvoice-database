<?php

namespace Database\Seeders;

use App\Models\RoleType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json = file_get_contents(base_path('resources/json/permission.json'));
        $permissions = json_decode($json);

        // info(json_encode($permissions->permissions));

        DB::table('role_types')->truncate();
        DB::table('target_roles')->truncate();
        DB::table('access_right_groups')->truncate();
        foreach ($permissions->permissions as $permission) {
            $roleType = RoleType::create(['name' => $permission->type]);

            foreach ($permission->groups as $group) {
                $roleGroup = $roleType->Groups()->create([
                    'name' => $group->name,
                    'description' => $group->name,
                ]);

                foreach ($group->roles as $roleName) {
                    info($roleName);
                    $roleGroup->AccessGroups()->create(['name' => $roleName]);
                }
            }
        }

    }
}
