<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class SettingFacade
 * @package App\Facades
 */
class SettingFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Setting';
    }
}
