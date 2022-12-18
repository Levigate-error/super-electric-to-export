<?php

namespace Database\Seeds\Helpers;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory;
use PhpOffice\PhpSpreadsheet\Settings as SpreadsheetSettings;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Console\Command;

/**
 * Class CatalogResources
 * @package Database\Seeds\Helpers
 */
class CatalogResources
{
    protected const COLUMN_TITLE_ROW = 3;
    protected const FILES_START_COLUMN = 'K';
    protected const PROPERTIES_START_COLUMN = 'DS';

    protected const FILE_PARAMS_ORDER = [
        'type', 'description', 'file_link', 'comment',
    ];

    protected const DEFAULT_UNIT = [
        'ru' => 'ШТ',
    ];

    protected const CATALOG_BASE_PATH = 'resources'.DIRECTORY_SEPARATOR.'catalog'.DIRECTORY_SEPARATOR;

    protected const REQUIRE_FIELDS = [
        'category',
        'division',
        'family_name',
        'vendor_code',
        'name',
        'recommended_retail_price',
    ];

    /**
     * @var CacheInterface
     */
    public $spreadsheetsCache;

    /**
     * @var CacheInterface
     */
    public $output;

    /**
     * @var Worksheet
     */
    public $worksheet;

    /**
     * @var array
     */
    public $worksheetAsArray;

    /**
     * @var array
     */
    public $worksheetTitles;

    /**
     * CatalogResources constructor.
     */
    public function __construct()
    {
        $this->spreadsheetsCache = SpreadsheetSettings::getCache();
        $this->output = new ConsoleOutput();
    }

    protected function clearSpreadsheetsCache(): void
    {
        $this->spreadsheetsCache->clear();
    }

    /**
     * Берем все файлы из папки с ресурсами и парсим
     *
     * @param  Command  $command
     * @param  string  $lang
     * @param  bool  $clearCache
     *
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function getProductsFromFiles(Command $command, string $lang, bool $clearCache = true): array
    {
        $files = array_diff(scandir($this->getResourcesDir($lang)), ['..', '.', 'new']);

        $products = [];
        foreach ($files as $file) {
            if (!$fileContent = $this->getWorksheetFromResources($file)) {
                continue;
            }

            $command->line('Parse file: '.$file);

            $this->worksheet = $fileContent;

            $highestRow = $this->worksheet->getHighestRow('A');
            $highestColumn = $this->worksheet->getHighestColumn();
            $this->worksheetAsArray = $this->worksheet->rangeToArray('A1:' . $highestColumn . $highestRow, null, true, true, true);

            $this->worksheetTitles = $this->worksheetAsArray[self::COLUMN_TITLE_ROW];

            $currentProducts = $this->getProductsFromWorksheet($clearCache, $lang);

            $products = array_merge($products, $currentProducts);
        }

        return $products;
    }

    /**
     * Парсим конкретный лист
     *
     * @param  bool  $clearCache
     * @param  string  $lang
     *
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getProductsFromWorksheet(bool $clearCache, string $lang): array
    {
        $rows = $this->worksheetAsArray;

        $products = [];
        foreach ($rows as $rowNumber => $rowValues) {
            if ($rowNumber <= self::COLUMN_TITLE_ROW) {
                continue;
            }

            $currentProduct = $this->getProductFromRow($rowValues, $lang);

            if (empty($currentProduct)) {
                continue;
            }

            $products[] = $currentProduct;
        }

        if ($clearCache) {
            $this->clearSpreadsheetsCache();
        }

        return $products;
    }

    /**
     * @param  array  $product
     *
     * @return bool
     */
    protected function validate(array $product): bool
    {
        foreach (static::REQUIRE_FIELDS as $requireField) {
            if (empty($product[$requireField]) === true) {
                return false;
            }
        }

        return true;
    }

    /**
     * Парсим запись о товаре
     *
     * @param  array  $row
     * @param  string  $lang
     * @return array|null
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getProductFromRow(array $row, string $lang): ?array
    {
        $product = array_map('trim', [
            'category' => $row['A'],
            'division' => $row['B'],
            'family_code' => $row['C'],
            'family_name' => $row['D'],
            'vendor_code' => $row['E'],
            'name' => $row['F'],
            'family_number' => $row['H'],
        ]);

        $product['recommended_retail_price'] = (float) $row['G'];

        if (!$this->validate($product)) {
            return null;
        }

        $product['unit'] = empty($row['J']) ? self::DEFAULT_UNIT[$lang] : $row['J'];
        $product['min_amount'] = empty($row['I']) ? 0 : (int) $row['I'];
        $product['files'] = [];
        $product['properties'] = [];

        $fileIteration = 0;
        $fileIndex = 0;
        $fileParamsCount = count(self::FILE_PARAMS_ORDER);
        $filesStartIndex = Coordinate::columnIndexFromString(self::FILES_START_COLUMN);

        $propertiesStartIndex = Coordinate::columnIndexFromString(self::PROPERTIES_START_COLUMN);

        foreach ($row as $letter => $value) {
            $letterIndex = Coordinate::columnIndexFromString($letter);

            if ($letterIndex < $filesStartIndex) {
                continue;
            }

            /**
             * Собираем файлы товара
             */
            if ($letterIndex < $propertiesStartIndex) {
                if (!isset(self::FILE_PARAMS_ORDER[$fileIteration])) {
                    continue;
                }

                $product['files'][$fileIndex][self::FILE_PARAMS_ORDER[$fileIteration]] = $value;
                $fileIteration++;

                if ($fileIteration === $fileParamsCount) {
                    $fileIteration = 0;
                    $fileIndex++;
                }
            }

            if (empty($value)) {
                continue;
            }

            /**
             * Собираем дополнительные параметры товара
             */
            if ($letterIndex >= $propertiesStartIndex) {
                $product['properties'][] = [
                    'title' => $this->worksheetTitles[$letter],
                    'value' => $value,
                ];
            }
        }

        return $product;
    }

    /**
     * @param  string  $src
     * @param  string  $lang
     * @param  string  $sheetName
     *
     * @return Worksheet
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    protected function getWorksheetFromResources(
        string $src,
        string $lang = 'ru',
        string $sheetName = 'Worksheet'
    ): Worksheet {
        return $this->getWorksheet($this->getResourcesDir($lang).DIRECTORY_SEPARATOR.$src, $sheetName);
    }

    /**
     * @param  string  $src
     * @param  string  $sheetName
     *
     * @return Worksheet|null
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    protected function getWorksheet(string $src, string $sheetName = 'Worksheet'): ?Worksheet
    {
        $worksheet = SpreadsheetIOFactory::load($src)->getSheetByName($sheetName);

        if (is_null($worksheet)) {
            throw new \LogicException("Sheet \"$sheetName\" is missing at file $src");
        }

        return $worksheet;
    }

    /**
     * @param  string  $lang
     *
     * @return string
     */
    protected function getResourcesDir(string $lang = 'ru'): string
    {
        return dirname(__DIR__).DIRECTORY_SEPARATOR.static::CATALOG_BASE_PATH.$lang;
    }
}
