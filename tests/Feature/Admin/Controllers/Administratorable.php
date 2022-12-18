<?php

namespace Tests\Feature\Admin\Controllers;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;

/**
 * Trait Administratorable
 * @package Tests\Feature\Admin\Controllers
 */
trait Administratorable
{
    /**
     * @return Administrator
     */
    public function createAdministrator(): Administrator
    {
        $user = factory(Administrator::class)->create();
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();

        $user->roles()->save($role);
        $role->permissions()->save($permission);

        return $user;
    }

    /**
     * @return $this
     */
    public function createAndLoginAdministrator(): self
    {
        $user = $this->createAdministrator();

        return $this->actingAs($user, config('admin.auth.guard'));
    }
}
