<?php

namespace Database\Seeds\Helpers;

/**
 * Class CertificateResources
 * @package Database\Seeds\Helpers
 */
class CertificateResources extends BaseHelperResources
{
    protected const RESOURCE_DIR = 'loyalty_certificates';

    /**
     * @param  array  $worksheetRows
     * @return array
     */
    protected function getDataFromWorksheet(array $worksheetRows): array
    {
        $certificates = [];
        foreach ($worksheetRows as $row) {
            $certificates[] = trim((string) $row['A']);
        }

        return $certificates;
    }
}
