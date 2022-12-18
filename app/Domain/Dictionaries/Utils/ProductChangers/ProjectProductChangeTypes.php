<?php

namespace App\Domain\Dictionaries\Utils\ProductChangers;

/**
 * Class ProjectProductChangeTypes
 * @package App\Domain\Dictionaries\Utils\ProductChangers
 */
class ProjectProductChangeTypes
{
    public const IN_STOCK_YES = 'in_stock_yes';
    public const IN_STOCK_NO = 'in_stock_no';
    public const AMOUNT_UP = 'amount_up';
    public const AMOUNT_DOWN = 'amount_down';
    public const REAL_PRICE_UP = 'real_price_up';
    public const REAL_PRICE_DOWN = 'real_price_down';
    public const DISCOUNT_UP = 'discount_up';
    public const DISCOUNT_DOWN = 'discount_down';
    public const REMOVED = 'removed';
    public const ADDED = 'added';
    public const ANALOG = 'analog';

    /**
     * Возвращает тип изменения на человеко-понятном языке
     *
     * @param string $key
     * @return string
     */
    public static function toHuman(string $key): string
    {
        $resource = [
            self::IN_STOCK_YES => __('project.changes.in_stock_yes'),
            self::IN_STOCK_NO => __('project.changes.in_stock_no'),
            self::AMOUNT_UP => __('project.changes.amount_up'),
            self::AMOUNT_DOWN => __('project.changes.amount_down'),
            self::REAL_PRICE_UP => __('project.changes.real_price_up'),
            self::REAL_PRICE_DOWN => __('project.changes.real_price_down'),
            self::DISCOUNT_UP => __('project.changes.discount_up'),
            self::DISCOUNT_DOWN => __('project.changes.discount_down'),
            self::REMOVED => __('project.changes.removed'),
            self::ADDED => __('project.changes.added'),
            self::ANALOG => __('project.changes.analog'),
        ];

        if (!isset($resource[$key])) {
            return $key;
        }

        return $resource[$key];
    }
}
