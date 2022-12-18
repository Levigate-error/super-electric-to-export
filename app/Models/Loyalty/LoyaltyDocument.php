<?php

namespace App\Models\Loyalty;

use App\Models\BaseModel;
use Illuminate\Notifications\Notifiable;
use App\Notifications\HasNotificationTransport;
use App\Traits\HasExternalEntity;

class LoyaltyDocument extends BaseModel
{
    use Notifiable;
    use HasNotificationTransport;
    use HasExternalEntity;

    protected $fillable = ['file', 'published'];

}
