<?php

namespace App\Admin\Services;

use App\Traits\ServiceGetter;
use Encore\Admin\Form;
use Encore\Admin\Grid;

/**
 * Class BaseService
 * @package App\Admin\Services
 */
abstract class BaseService
{
    use ServiceGetter;

    /**
     * @return mixed
     */
    abstract public function getCrudPageContent();

    /**
     * @return mixed
     */
    abstract public function getFormContent();

    /**
     * @param int $id
     * @return mixed
     */
    abstract public function getDetailPageContent(int $id);

    /**
     * Стандартные данные для булевой переключалки
     *
     * @return array
     */
    protected function getOptionsForSwitch(): array
    {
        return [
            'on'  => [
                'value' => true,
                'text' => 'Да',
                'color' => 'primary',
            ],
            'off' => [
                'value' => false,
                'text' => 'Нет',
                'color' => 'default',
            ],
        ];
    }
}
