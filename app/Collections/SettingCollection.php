<?php

namespace App\Collections;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Setting;

/**
 * Class SettingCollection
 * @package App\Collections
 */
class SettingCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Setting::class];
}
