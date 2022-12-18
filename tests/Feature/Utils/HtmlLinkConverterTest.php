<?php

namespace Tests\Feature\Utils;

use App\Helpers\HtmlTagHelper;
use App\Utils\HtmlLinkConverter;
use Tests\TestCase;

/**
 * Class HtmlLinkConverterTest
 *
 * Тест конвертора ссылок.
 *
 * @package Tests\Feature\Utils
 */
class HtmlLinkConverterTest extends TestCase
{
    /**
     * Тест конвертации значения.
     */
    public function testSuccessConvert(): void
    {
        $inputText = "test https://kvvhost.ru/2020/07/25/legrand-with-netatmo/ test <a href='https://kvvhost.ru/qweqweqw' target='_self'>https://kvvhost.ru/qweqweqw</a>";
        $expectedText = "test <a href='https://kvvhost.ru/2020/07/25/legrand-with-netatmo/' target='_blank'>https://kvvhost.ru/2020/07/25/legrand-with-netatmo/</a> test <a href='https://kvvhost.ru/qweqweqw' target='_self'>https://kvvhost.ru/qweqweqw</a>";
        $outputText = HtmlLinkConverter::convert($inputText, HtmlTagHelper::TARGET_BLANK);
        $this->assertNotSame($inputText, $outputText);
        $this->assertSame($expectedText, $outputText);
    }
}
