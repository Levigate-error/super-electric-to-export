<?php

namespace Database\Seeds\Helpers;

use Database\Seeds\Import\Catalog\CatalogField;
use Database\Seeds\Import\Catalog\CatalogType;
use Database\Seeds\Import\Catalog\Resources\BaseResource;
use Database\Seeds\Import\Catalog\Resources\CatalogNetatmo;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
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
class CatalogNewResources
{

    /** @var BaseResource */
    public $currentResource;

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
     * @param Command $command
     * @param string $lang
     * @param bool $clearCache
     *
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws Exception
     */
    public function getProductsFromFiles(Command $command, string $lang, bool $clearCache = true): array
    {
        $resources = [
            CatalogNetatmo::class,
        ];

        $products = [];

        foreach ($resources as $resource) {
            $this->currentResource = new $resource($lang);

            if (!$fileContent = $this->getWorksheetFromResources($this->currentResource->getPath(), $this->currentResource->getSheetName())) {
                continue;
            }

            $this->message('Parse file: "' . $this->currentResource->getFileName() . '"');

            $this->worksheet = $fileContent;

            $highestRow = $this->worksheet->getHighestRow('A');

            $highestColumn = $this->worksheet->getHighestColumn();
            $this->worksheetAsArray = $this->worksheet->rangeToArray('A1:' . $highestColumn . $highestRow, null, true, true, true);

            $this->worksheetTitles = $this->worksheetAsArray[$this->currentResource->getColumnTitleRow()];

            $currentProducts = $this->getProductsFromWorksheet($clearCache, $lang);

            $products = array_merge($products, $currentProducts);
        }

        return $products;
    }

    /**
     * Парсим конкретный лист
     *
     * @param bool $clearCache
     * @param string $lang
     *
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getProductsFromWorksheet(bool $clearCache, string $lang): array
    {
        $rows = $this->worksheetAsArray;

        $products = [];
        foreach ($rows as $rowNumber => $rowValues) {
            if ($rowNumber <= $this->currentResource->getColumnTitleRow()) {
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
     * @param array $product
     *
     * @return bool
     */
    protected function validate(array $product): bool
    {
        foreach ($this->getRequiredFields() as $type) {
            /** @var CatalogType $type */
            if (empty($product[$type->field]) === true) {
                return false;
            }
        }

        return true;
    }

    /**
     * Парсим запись о товаре
     *
     * @param array $row
     * @param string $lang
     * @return array|null
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getProductFromRow(array $row, string $lang): ?array
    {
        $product = [
            'files' => [],
            'properties' => []
        ];
        $imageSort = 100;

        foreach ($this->currentResource->getCoordinate() as $key => $item) {
            //Штатный мапинг полей
            if ($item instanceof CatalogType) {
                if (!empty($row[$key]) && in_array($item->type, [CatalogType::TYPE_PROPERTY, CatalogType::TYPE_FILE], true)) {
                    if ($item->getPropertyType() === $item::PROPERTY_TYPE_IMAGE) {
                        $item->setSortField($imageSort);
                        $imageSort += 100;
                    }
                    $product[$item->field][] = $item->title($this->worksheetTitles[$key])->value((string)$row[$key])->formatted();
                }

                if (in_array($item->type, [CatalogType::TYPE_STRING, CatalogType::TYPE_INTEGER, CatalogType::TYPE_FLOAT], true)) {
                    $product[$item->field] = $item->value((string)$row[$key])->formatted();
                }
            }

            //Кастомизация через callback
            if ($item instanceof \Closure) {
                $callback = $item($row, $lang);
                if ($callback instanceof CatalogType) {

                    if (in_array($callback->type, [CatalogType::TYPE_PROPERTY, CatalogType::TYPE_FILE], true)) {
                        $product[$callback->field][] = $callback->formatted();
                    }

                    if (in_array($callback->type, [CatalogType::TYPE_STRING, CatalogType::TYPE_INTEGER, CatalogType::TYPE_FLOAT], true)) {
                        $product[$callback->field] = $callback->formatted();
                    }
                }
            }
        }

        return $product;
    }


    /**
     * @param string $src
     * @param string $sheetName
     *
     * @return Worksheet
     * @throws Exception
     */
    protected function getWorksheetFromResources(string $src, string $sheetName = 'Worksheet'): Worksheet
    {
        return $this->getWorksheet($src, $sheetName);
    }

    /**
     * @param string $src
     * @param string $sheetName
     *
     * @return Worksheet|null
     * @throws Exception
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
     * @param string $lang
     *
     * @return string
     */
    protected function getResourcesDir(string $lang = 'ru'): string
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . static::CATALOG_BASE_PATH . $lang;
    }


    protected function message(string $message): void
    {
        //$this->info('Parse file: ' . $message);
        echo $message . '<br>';
    }


    protected function getRequiredFields(): array
    {
        return [
            CatalogField::category(),
            CatalogField::division(),
            CatalogField::familyName(),
            CatalogField::vendorCode(),
            CatalogField::name(),
            CatalogField::recommendedRetailPrice()
        ];
    }
}
