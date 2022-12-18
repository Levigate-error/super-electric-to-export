<?php

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Permission;
use Illuminate\Database\Seeder;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Support\Facades\DB;

/**
 * Class AdminUserRolePermissionSeeder
 */
class AdminUserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_users')->truncate();

        // create a user.
        Administrator::truncate();
        $user = Administrator::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'name'     => 'Administrator',
        ]);

        // create a role.
        Role::truncate();
        $role = Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
        ]);

        // add role to user.
        $user->roles()->save($role);

        //create a permission
        Permission::truncate();
        Permission::insert([
            [
                'name'        => 'All permission',
                'slug'        => '*',
                'http_method' => '',
                'http_path'   => '*',
            ],
            [
                'name'        => 'Dashboard',
                'slug'        => 'dashboard',
                'http_method' => 'GET',
                'http_path'   => '/',
            ],
            [
                'name'        => 'Login',
                'slug'        => 'auth.login',
                'http_method' => '',
                'http_path'   => "/auth/login\r\n/auth/logout",
            ],
            [
                'name'        => 'User setting',
                'slug'        => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path'   => '/auth/setting',
            ],
            [
                'name'        => 'Auth management',
                'slug'        => 'auth.management',
                'http_method' => '',
                'http_path'   => "/auth/roles\r\n/auth/permissions\r\n/auth/menu\r\n/auth/logs",
            ],
        ]);

        $role->permissions()->save(Permission::first());
    }
}
