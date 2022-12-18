<?php

namespace App\Helpers;

/**
 * Class HtmlTagHelper
 *
 * Хелпер html тэгов.
 *
 * @package App\Helpers
 */
class HtmlTagHelper
{
    public const TARGET_SELF  = '_self';
    public const TARGET_BLANK = '_blank';

    /**
     * Создать html ссылку.
     *
     * @param string $link
     * @param string $name
     * @param string $target
     * @param array  $options
     *
     * @return string
     */
    public static function a(string $link, string $name, string $target = HtmlTagHelper::TARGET_SELF, array $options = []): string
    {
        if (empty($options) === false) {
            $optionsString = static::prepareOptions($options);
            return "<a href='$link' target='$target' $optionsString>$name</a>";
        }

        return "<a href='$link' target='$target'>$name</a>";
    }

    /**
     * Сформировать строку опций.
     *
     * @param array $options
     *
     * @return string
     */
    protected static function prepareOptions(array $options): string
    {
        $res = [];
        foreach ($options as $name => $value) {
            $res[] = "$name='$value'";
        }

        return implode(' ', $res);
    }
}
