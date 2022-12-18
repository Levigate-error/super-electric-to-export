<?php

use App\Models\Loyalty\LoyaltyUser;
use App\Models\Loyalty\LoyaltyUserProposal;
use App\Models\Loyalty\LoyaltyUserPoint;
use App\Models\Loyalty\LoyaltyProductCode;
use Faker\Generator as Faker;

$factory->define(LoyaltyUserProposal::class, static function (Faker $faker) {
    $loyaltyUser = LoyaltyUser::inRandomOrder()->first();
    if (empty($loyaltyUser) === true) {
        $loyaltyUser = factory(LoyaltyUser::class)->create();
    }

    $loyaltyUserPoint = LoyaltyUserPoint::query()->where(['loyalty_user_id' => $loyaltyUser->id])->first();
    if (empty($loyaltyUserPoint) === true) {
        $loyaltyUserPoint = factory(LoyaltyUserPoint::class)->create(['loyalty_user_id' => $loyaltyUser->id]);
    }

    $loyaltyProductCode = LoyaltyProductCode::inRandomOrder()->first();
    if (empty($loyaltyProductCode) === true) {
        $loyaltyProductCode = factory(LoyaltyProductCode::class)->create();
    }

    return [
        'points' => 1,
        'loyalty_user_point_id' => $loyaltyUserPoint->id,
        'loyalty_product_code_id' => $loyaltyProductCode->id,
        'proposal_status' => 'new',
        'code' => $loyaltyProductCode->code,
    ];
});
