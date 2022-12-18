<?php

namespace App\Domain\Dictionaries;

/**
 * Class BaseDictionary
 * @package App\Domain\Dictionaries
 */
abstract class BaseDictionary
{
    /**
     * @return array
     */
    abstract public static function getToHumanResource(): array;

    /**
     * @param string $key
     * @return string
     */
    public static function toHuman(string $key): string
    {
        $resource = static::getToHumanResource();

        if (static::checkExist($key) === false) {
            return $key;
        }

        return $resource[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function checkExist(string $key): bool
    {
        $resource = static::getToHumanResource();

        return isset($resource[$key]);
    }
}
