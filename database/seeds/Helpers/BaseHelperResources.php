<?php

namespace Database\Seeds\Helpers;

use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory;

/**
 * Class BaseHelperResources
 * @package Database\Seeds\Helpers
 */
abstract class BaseHelperResources
{
    protected const MAIN_RESOURCE_DIR = 'resources';

    protected const RESOURCE_DIR = '';

    protected const COLUMN_FOR_HIGHEST_ROW = 'A';

    protected const ROW_FOR_HIGHEST_COLUMN = '1';

    /**
     * @param  array  $worksheetRows
     * @return array
     */
    abstract protected function getDataFromWorksheet(array $worksheetRows): array;

    /**
     * @return array
     * @throws Exception
     */
    public function getData(): array
    {
        $directory = $this->getResourcesDir();

        $files = array_diff(scandir($directory), ['..', '.']);

        $data = [];
        foreach ($files as $file) {
            $data = array_merge($data, $this->getFileData($file));
        }

        return $data;
    }

    /**
     * @param  string  $file
     * @return array
     * @throws Exception
     */
    protected function getFileData(string $file): array
    {
        if (!$spreadsheet = $this->getSpreadsheet($file)) {
            return [];
        }

        $sheets = $spreadsheet->getAllSheets();

        $data = [];
        foreach ($sheets as $sheet) {
            $data = array_merge($data, $this->getSheetData($sheet));
        }

        return $data;
    }

    /**
     * @param  Worksheet  $worksheet
     * @return array
     */
    protected function getSheetData(Worksheet $worksheet): array
    {
        $highestRow = $worksheet->getHighestRow(static::COLUMN_FOR_HIGHEST_ROW);
        $highestColumn = $worksheet->getHighestColumn(static::ROW_FOR_HIGHEST_COLUMN);

        $worksheetAsArray = $worksheet->rangeToArray('A1:'.$highestColumn.$highestRow, null, true, true, true);

        return $this->getDataFromWorksheet($worksheetAsArray);
    }

    /**
     * @param  string  $file
     * @param  string|null  $resourceDir
     * @return Spreadsheet
     * @throws Exception
     */
    protected function getSpreadsheet(string $file, ?string $resourceDir = null): Spreadsheet
    {
        return SpreadsheetIOFactory::load($this->getResourcesDir($resourceDir).$file);
    }

    /**
     * @param  string|null  $resourceDir
     * @return string
     */
    protected function getResourcesDir(?string $resourceDir = null): string
    {
        return implode(DIRECTORY_SEPARATOR, [
            dirname(__DIR__),
            static::MAIN_RESOURCE_DIR,
            $resourceDir ?? static::RESOURCE_DIR,
        ]) . DIRECTORY_SEPARATOR;
}
}
