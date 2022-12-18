<?php

namespace App\Models\Loyalty;

use Illuminate\Database\Eloquent\Model;

class LoyaltyUserPrizeWinning extends Model
{
    protected $fillable = [
        'month',
        'status',
        'title',
    ];

    public function loyaltyUser()
    {
        return $this->belongsTo(LoyaltyUser::class);
    }
}
