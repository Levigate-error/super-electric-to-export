<?php

namespace Database\Seeds\Helpers;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory;

/**
 * Class CityResources
 * @package Database\Seeds\Helpers
 */
class CityResources
{
    public const HEADER_ROW = 1;
    public const FILE = 'cities.xlsx';

    /**
     * @param array $langs
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function getData(array $langs): array
    {
        $spreadsheet = $this->getSpreadsheet();

        return $this->getFileCities($spreadsheet, $langs);
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param array $langs
     * @return array
     */
    protected function getFileCities(Spreadsheet $spreadsheet, array $langs): array
    {
        $sheets = $spreadsheet->getAllSheets();

        $cities = [];
        foreach ($sheets as $sheet) {
            $cities = array_merge($cities, $this->getSheetCities($sheet, $langs));
        }

        return $cities;
    }

    /**
     * @param Worksheet $sheet
     * @param array $langs
     * @return array
     */
    protected function getSheetCities(Worksheet $sheet, array $langs): array
    {
        $sheetRows = $sheet->toArray(null, true, true, true);

        $cities = [];
        foreach ($sheetRows as $rowNumber => $rowValues) {
            if ($rowNumber === self::HEADER_ROW) {
                continue;
            }

            $cityLang = [];
            foreach ($langs as $langCode => $langCol) {
                $cityLang[$langCode] = trim($rowValues[$langCol]);
            }

            $cities[] = $cityLang;
        }

        return $cities;
    }

    /**
     * @return Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    protected function getSpreadsheet(): Spreadsheet
    {
        return SpreadsheetIOFactory::load($this->getResourcesDir() . DIRECTORY_SEPARATOR . static::FILE);
    }

    /**
     * @return string
     */
    protected function getResourcesDir(): string
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'cities' . DIRECTORY_SEPARATOR;
    }
}
