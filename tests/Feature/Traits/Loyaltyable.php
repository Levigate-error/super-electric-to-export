<?php

namespace Tests\Feature\Traits;

use App\Models\Certificate;
use App\Models\Loyalty\Loyalty;
use App\Models\User;

/**
 * Trait Loyaltyable
 * @package Tests\Feature\Traits
 */
trait Loyaltyable
{
    /**
     * @param  User  $user
     */
    protected function registerInLoyaltyProgram(User $user): void
    {
        $certificate = factory(Certificate::class)->create();
        $loyalty = factory(Loyalty::class)->create();

        $response = $this->actingAs($user)
            ->json('POST', route('api.loyalty.register-user'), [
                    'code' => $certificate->code,
                    'loyalty_id' => $loyalty->id,
                ]
            );

        $response->assertOk();
    }
}
