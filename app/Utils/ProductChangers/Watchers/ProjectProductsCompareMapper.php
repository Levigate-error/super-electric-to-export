<?php

namespace App\Utils\ProductChangers\Watchers;

use App\Domain\Dictionaries\Utils\ProductChangers\BaseChangeTypes;
use App\Exceptions\WrongArgumentException;

/**
 * Class ProjectProductsCompareMapper
 * @package App\Utils\ProductChangers\Watchers
 */
class ProjectProductsCompareMapper
{
    /**
     * @var array
     */
    private $map = [
        'vendor_code' => [
            [
                'key' => 'in_stock',
                'type' => BaseChangeTypes::BOOLEAN,
            ],
            [
                'key' => 'amount',
                'type' => BaseChangeTypes::NUMERIC,
            ],
            [
                'key' => 'real_price',
                'type' => BaseChangeTypes::NUMERIC,
            ],

            [
                'key' => 'discount',
                'type' => BaseChangeTypes::NUMERIC,
            ],
        ]
    ];

    /**
     * @param string $mapKey
     * @return array
     */
    public function getMap(string $mapKey): array
    {
        if (!isset($this->map[$mapKey])) {
            throw new WrongArgumentException("Map for key [$mapKey] does not exist.");
        }

        return $this->map[$mapKey];
    }
}
