<?php

namespace App\Utils;

use InvalidArgumentException;

/**
 * Class YouTubeLinkConverter
 *
 * Конвертор ссылок на видео с youtube.
 *
 * @package App\Utils
 */
class YouTubeLinkConverter
{
    protected static $url = 'https://www.youtube.com/embed/';

    /**
     * {@inheritDoc}
     */
    public static function convert(string $inputUrl): string
    {
        if (strripos($inputUrl, self::$url) !== false) {
            return $inputUrl;
        }

        $splitInputUrl = explode('/', $inputUrl);

        $videoCode = end($splitInputUrl);

        if ($videoCode === false || is_string($videoCode) === false) {
            throw new InvalidArgumentException('Invalid input url');
        }

        return self::$url . $videoCode;
    }
}
