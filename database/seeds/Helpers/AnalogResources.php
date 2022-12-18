<?php

namespace Database\Seeds\Helpers;

use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory;

/**
 * Class AnalogResources
 * @package Database\Seeds\Helpers
 */
class AnalogResources
{
    public const COLUMN_HEADER_ROW = 1;
    public const SKIP_HEADER_TITLE = 'Описание';
    public const SKIP_HEADER_ANALOG_PREFIX = 'Референс';

    /**
     * @param string $lang
     * @param bool $clearCache
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function getAnaloguesFromFiles(string $lang, bool $clearCache = true): array
    {
        $files = array_diff(scandir($this->getResourcesDir($lang)), ['..', '.']);

        $analogues = [];
        foreach ($files as $file) {
            if (!$spreadsheet = $this->getSpreadsheet($file, $lang)) {
                continue;
            }

            $analogues[$file] = $this->getFileAnalogues($spreadsheet, $clearCache);
        }

        return $analogues;
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @param bool $clearCache
     * @return array
     */
    protected function getFileAnalogues(Spreadsheet $spreadsheet, bool $clearCache = true): array
    {
        $sheets = $spreadsheet->getAllSheets();

        $analogues = [];
        foreach ($sheets as $sheet) {
            $analogues[$sheet->getTitle()] = $this->getSheetAnalogues($sheet, $clearCache);
        }

        return $analogues;
    }

    /**
     * @param Worksheet $sheet
     * @param bool $clearCache
     * @return array
     */
    protected function getSheetAnalogues(Worksheet $sheet, bool $clearCache = true): array
    {
        $sheetRows = $sheet->toArray(null, true, true, true);

        $analogues = [];
        foreach ($sheetRows as $rowNumber => $rowValues) {
            if ($rowNumber === self::COLUMN_HEADER_ROW) {
                foreach ($rowValues as $headerKey => $headerValue) {
                    $headerValue = trim($headerValue);

                    if (Str::startsWith($headerValue, self::SKIP_HEADER_ANALOG_PREFIX)) {
                        $analogTitle = trim(str_replace(self::SKIP_HEADER_ANALOG_PREFIX, '', $headerValue));

                        if (!isset($analogues[$analogTitle])) {
                            $analogues[$analogTitle] = [
                                'vendor_code' => $headerKey,
                            ];
                        }
                    }

                    if ($headerValue === self::SKIP_HEADER_TITLE) {
                        $lastAnalogTitle = array_key_last($analogues);

                        if (!isset($analogues[$lastAnalogTitle]['description'])) {
                            $analogues[$lastAnalogTitle]['description'] = $headerKey;
                        }
                    }
                }

                continue;
            }

            $analogues = $this->getAnaloguesFromRow($rowValues, $analogues);
        }

        return $analogues;
    }

    /**
     * @param array $rowValues
     * @param array $analogues
     * @return array
     */
    protected function getAnaloguesFromRow(array $rowValues, array $analogues): array
    {
        foreach ($analogues as $analogKey => $analogValue) {
            if (!isset($analogues[$analogKey]['items'])) {
                $analogues[$analogKey]['items'] = [];
            }

            $analogues[$analogKey]['items'][] = [
                'vendor_code' => trim($rowValues[$analogValue['vendor_code']]),
                'description' => trim($rowValues[$analogValue['description']]),
                'vendor' => $analogKey,
            ];
        }

        return $analogues;
    }

    /**
     * @param string $file
     * @param string $lang
     * @return Spreadsheet
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    protected function getSpreadsheet(string $file, string $lang = 'ru'): Spreadsheet
    {
        return SpreadsheetIOFactory::load($this->getResourcesDir($lang) . DIRECTORY_SEPARATOR . $file);
    }

    /**
     * @param string $lang
     *
     * @return string
     */
    protected function getResourcesDir(string $lang = 'ru'): string
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'analogues' . DIRECTORY_SEPARATOR . $lang;
    }
}
