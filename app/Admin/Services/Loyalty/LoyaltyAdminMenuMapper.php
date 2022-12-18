<?php

namespace App\Admin\Services\Loyalty;

use App\Domain\Mappers\BaseMapper;

/**
 * Маппер верхнего меню в админке в разделе деталей акции
 *
 * Class LoyaltyAdminMenuMapper
 * @package App\Admin\Services\Loyalty
 */
class LoyaltyAdminMenuMapper extends BaseMapper
{
    public const DEFAULT_TYPE = 'LoyaltyUsers';

    /**
     * @var array
     */
    protected static $map = [
        [
            'title' => 'Регистрации в акции',
            'type' => 'LoyaltyUsers',
        ],
        [
            'title' => 'Регистрации кодов продуктов',
            'type' => 'LoyaltyProposals',
        ],
        [
            'title' => 'Турнирная таблица',
            'type' => 'LoyaltyStandings',
        ],
        [
            'title' => 'Детали акции',
            'type' => 'Loyalty',
        ],
    ];
}
