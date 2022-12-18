<?php

namespace App\Utils\Files\Mappers\Specification;

use App\Domain\UtilContracts\Files\FilesMapperContract;
use App\Exceptions\WrongArgumentException;

/**
 * Class ExcelMapper
 * @package App\Utils\Files\Mappers\Specification
 */
class ExcelMapper implements FilesMapperContract
{
    /**
     * @var array
     */
    private $map = [
        'products' => [
            'A' => 'vendor_code',
            'B' => 'name',
            'C' => 'amount',
            'D' => 'real_price',
            'E' => 'in_stock',
            'F' => 'discount',
            'G' => 'price_with_discount',
        ],
        'specification' => [
            'A' => 'section',
            'B' => 'vendor_code',
            'C' => 'name',
            'D' => 'in_stock',
            'E' => 'amount',
            'F' => 'real_price',
            'G' => 'discount',
            'H' => 'price_with_discount',
            'I' => 'total_price',
        ],
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

    /**
     * @param string $mapKey
     * @param string $value
     * @return string|null
     */
    public function getKeyByValue(string $mapKey, string $value): ?string
    {
        $map = array_flip($this->getMap($mapKey));

        return $map[$value] ?? null;
    }
}
