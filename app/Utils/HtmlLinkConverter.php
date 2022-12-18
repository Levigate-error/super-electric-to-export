<?php

namespace App\Utils;

use App\Helpers\HtmlTagHelper;
use Illuminate\Support\Arr;

/**
 * Class HtmlLinkPreparer
 *
 * Класс занимается преобразованием текстовых ссылок в html ссылки.
 *
 * @package App\Utils
 */
class HtmlLinkConverter
{
    /**
     * {@inheritDoc}
     */
    public static function convert(string $text, string $target): string
    {
        $allLinks = static::getAllLinks($text);
        $existHtmlLinks = static::getExistHtmlLinks($text);

        foreach (array_diff($allLinks, $existHtmlLinks) as $link) {
            $htmlLink = HtmlTagHelper::a($link, $link, $target);
            $text = str_replace($link, $htmlLink, $text);
        }

        return $text;
    }

    /**
     * Получить все ссылки в тексте.
     *
     * @param string $text
     *
     * @return array
     */
    protected static function getAllLinks(string $text): array
    {
        $links = [];
        preg_match_all('!(http|https):\/\/[a-zA-Z0-9.?%=&_/\-]+!', $text, $links);

        return Arr::get($links, 0);
    }

    /**
     * Получить существующие html ссылки в тексте.
     * Необходимо для исключения из конвертации.
     *
     * @param string $text
     *
     * @return array
     */
    protected static function getExistHtmlLinks(string $text): array
    {
        $links = [];
        preg_match_all('/<a.*?href=["\'](.*?)["\'].*?>/i', $text, $links);

        return Arr::get($links, 1);
    }
}
