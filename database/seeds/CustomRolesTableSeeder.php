<?php

use Illuminate\Database\Seeder;

class CustomRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $RoleItems = [
            [
                'name'        => 'electrician',
                'slug'        => 'electrician',
                'description' => 'electrician role',
                'level'       => 3,
            ],
            [
                'name'        => 'Store Manager',
                'slug'        => 'store.manager',
                'description' => 'Store manager role',
                'level'       => 2,
            ],
            [
                'name'        => 'Guest',
                'slug'        => 'guest',
                'description' => 'Guest Role',
                'level'       => 1,
            ],
        ];

        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name'          => $RoleItem['name'],
                    'slug'          => $RoleItem['slug'],
                    'description'   => $RoleItem['description'],
                    'level'         => $RoleItem['level'],
                ]);
            }
        }
    }
}
