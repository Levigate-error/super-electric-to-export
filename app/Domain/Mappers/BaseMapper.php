<?php

namespace App\Domain\Mappers;

/**
 * Class BaseMapper
 * @package App\Domain\Mappers
 */
abstract class BaseMapper
{
    protected static $map = [];

    /**
     * @return array
     */
    public static function getMap(): array
    {
        return static::$map;
    }
}
