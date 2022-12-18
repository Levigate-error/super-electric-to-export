<?php

namespace App\Domain\Mappers\Images;

use App\Domain\Mappers\BaseMapper;

/**
 * Class ImageSizes
 * @package App\Domain\Mappers\Images
 */
class ImageSizes extends BaseMapper
{
    /**
     * @var array
     */
    protected static $map = [
        '320x280' => '320x280',
        '576x280' => '576x280',
        '768x280' => '768x280',
        '992x280' => '992x280',
        '1200x280' => '1200x280',
    ];
}
