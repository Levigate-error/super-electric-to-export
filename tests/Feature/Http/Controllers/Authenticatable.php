<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;

/**
 * Trait Authenticatable
 * @package Tests\Feature\Http\Controllers
 */
trait Authenticatable
{
    /**
     * @return User
     */
    public function createUser(): User
    {
        return factory(User::class)->create();
    }

    /**
     * @return $this
     */
    public function createAndLoginUser(): self
    {
        $user = $this->createUser();

        return $this->actingAs($user);
    }
}
