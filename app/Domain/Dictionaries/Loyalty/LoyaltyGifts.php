<?php

namespace App\Domain\Dictionaries\Loyalty;

use App\Domain\Dictionaries\BaseDictionary;

/**
 * Class LoyaltyReceiptsStatuses
 * @package App\Domain\Dictionaries\Loyalty
 */
class LoyaltyGifts extends BaseDictionary
{
    /**
     * @return array
     */
    public static function getToHumanResource(): array
    {
        $old_gifts = [
            1 => 'Футболка Superelektrik',
            2 => 'Зарядка USB 3in1',
            3 => 'Набор Quteo IP44',
            4 => 'Беспроводная зарядка',
            5 => 'Набор автоматов 10А DX3-E',
            6 => 'Набор автоматов 16А DX3-E',
            7 => 'Набор "Inspiria"',
            8 => 'Набор "Quteo"',
            9 => 'Набор "Valena Life"',
            10 => 'Набор "Valena Allure"',
            11 => 'Набор "Plexo"',
            12 => 'Денежный приз на Qiwi-кошелёк',
            13 => 'Набор управления Netatmo',
            14 => 'Набор управления Netatmo',
            15 => 'Источник бесперебойного питания',
        ];

        return [
            1 => 'Футболка Superelektrik',
            2 => 'Мультитул',
            3 => 'Набор серии Quteo от Legrand',
            4 => 'Термокружка вакуумная Polo 500ml',
            5 => 'Набор Quteo IP44',
            6 => 'Набор серии INSPIRIA от Legrand',
            7 => 'Внешний аккумулятор 7800 mAh',
            8 => 'Удлинитель Legrand вертикальный',
            9 => 'Удлинитель Legrand горизонтальный',
            10 => 'Жилет Warm черный',
            11 => 'Рюкзак для ноутбука Burst, серый',
            12 => 'Рюкзак с логотипом Legrand',
            13 => 'Рюкзак с логотипом Legrand, малый треугольный',
            14 => 'Беспроводная оптическая мышь',
            15 => 'Беспроводная колонка',
            16 => 'Кружка красная',
            17 => 'Бутылка пластиковая',
            18 => 'Магнитный держатель телефона',
        ];
    }
}
