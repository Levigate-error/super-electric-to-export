<?php

namespace App\Admin\Extensions;

use App\Domain\Dictionaries\Loyalty\LoyaltyUserStatuses;
use App\Domain\Repositories\User\UserRepositoryContract;

class UsersExporter extends BaseCsvExporter
{
    protected $fileName = 'users.csv';

    protected $headings = [
        'ФИО',
        'Город',
        'Телефон',
        'Email',
        'Сайт / Страница в соц. сетях',
        'Согласен получать рассылки на эл.почту',
        'Регистрация в программе лояльности',
        'Количество баллов в программе лояльности',
        'Зарегистрированный номер сертификата',
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

        $users = app()->make(UserRepositoryContract::class)->getUsersForExport()->get();

        foreach ($users as $key => $user) {
            $data[$key] = $user->toArray();
            $data[$key]['city'] = $user->city !== null ? translate_field($data[$key]['city']) : '-';
            $data[$key]['email_subscription'] = $user->email_subscription === false ? 'Нет' : 'Да';
            $data[$key]['loyalty_status'] = $user->loyalty_status ?
                LoyaltyUserStatuses::toHuman($data[$key]['loyalty_status']) : 'Нет';
            $data[$key]['loyalty_points'] =  $user->loyalty_points ?? 'Нет';
            $data[$key]['certificate_code'] = $user->certificate_code ?? 'Нет';
        }

        return $data;
    }
}
