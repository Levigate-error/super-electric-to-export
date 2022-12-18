<?php

namespace App\Admin\Extensions;

class LoyaltyStandingExporter extends BaseCsvExporter
{
    protected $fileName = 'loyalty_standing.csv';

    protected $headings = [
        '№',
        'Фамилия',
        'Имя',
        'Телефон',
        'Email',
        'Город',
        'Кол-во баллов',
        'Место',
    ];

    /**
     * Получение данных для экспорта
     *
     * @param bool $toArray
     *
     * @return array
     */
    public function getData($toArray = true): array
    {
        $data = [];

        foreach (parent::getData(false) as $loyaltyUserStanding) {
            $user = $loyaltyUserStanding->loyaltyUser->user;

            $data[] = [
                $loyaltyUserStanding->id,
                $user->last_name,
                $user->first_name,
                $user->phone,
                $user->email,
                translate_field($user->city->title),
                $loyaltyUserStanding->points,
                $loyaltyUserStanding->place,
            ];
        }

        return $data;
    }
}
