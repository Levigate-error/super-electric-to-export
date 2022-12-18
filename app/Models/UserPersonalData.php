<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPersonalData extends Model
{
    protected $fillable = [
        'passport_series',
        'passport_number',
        'issuer',
        'issue_date',
        'issuer_code',
        'registration_address',
        'taxpayer_number',
    ];

    protected $casts = [
        'issue_date' => 'date'
    ];

    /**
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
