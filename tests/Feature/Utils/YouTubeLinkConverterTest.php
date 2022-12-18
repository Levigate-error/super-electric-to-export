<?php

namespace Tests\Feature\Utils;

use App\Utils\YouTubeLinkConverter;
use Tests\TestCase;

/**
 * Class YouTubeLinkConverterTest
 *
 * Тест конвертора ссылок youtube.
 *
 * @package Tests\Feature\Utils
 */
class YouTubeLinkConverterTest extends TestCase
{
    /**
     * Тест конвертации значения.
     */
    public function testSuccessConvert(): void
    {
        $inputUrl = 'https://youtu.be/_dOBWxLbC0E';
        $expectedUrl = 'https://www.youtube.com/embed/_dOBWxLbC0E';

        $outputUrl = YouTubeLinkConverter::convert($inputUrl);

        $this->assertSame($expectedUrl, $outputUrl);

        $inputUrl = 'https://www.youtube.com/embed/_dOBWxLbC0E';
        $expectedUrl = 'https://www.youtube.com/embed/_dOBWxLbC0E';

        $outputUrl = YouTubeLinkConverter::convert($inputUrl);

        $this->assertSame($expectedUrl, $outputUrl);
    }
}
