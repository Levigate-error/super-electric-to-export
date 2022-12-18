<?php

namespace Database\Seeds\Helpers;

/**
 * Class LoyaltyProductCodeResources
 * @package Database\Seeds\Helpers
 */
class LoyaltyProductCodeResources extends BaseHelperResources
{
    protected const RESOURCE_DIR = 'loyalty_product_codes';

    protected const START_ROW = 3;

    /**
     * @param  array  $worksheetRows
     * @return array
     */
    protected function getDataFromWorksheet(array $worksheetRows): array
    {
        $productCodes = [];
        foreach ($worksheetRows as $rowKey => $rowData) {
            if ($rowKey < static::START_ROW) {
                continue;
            }

            $productCodes[] = trim((string) $rowData['A']);
        }

        return $productCodes;
    }
}
