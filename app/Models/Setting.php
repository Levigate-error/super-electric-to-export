<?php

namespace App\Models;

use App\Collections\SettingCollection;

/**
 * Class Setting
 * @package App\Models
 */
class Setting extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['key', 'value'];

    /**
     * @param array $models
     * @return SettingCollection
     */
    public function newCollection(array $models = []): SettingCollection
    {
        return new SettingCollection($models);
    }
}
