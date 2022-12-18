<?php

namespace Database\Seeds\Import\Catalog\Resources;


use Database\Seeds\Import\Catalog\CatalogField;
use Database\Seeds\Import\Catalog\CatalogType;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Exception;

abstract class BaseResource
{
    /** @var int номер строки с заголовками */
    public const COLUMN_TITLE_ROW = 1;

    /** @var string Директория */
    protected const CATALOG_BASE_PATH = 'resources' . DIRECTORY_SEPARATOR . 'catalog' . DIRECTORY_SEPARATOR;

    /** @var string название листа */
    protected $sheetName = 'Worksheet';

    /** @var string название файла */
    protected $filename;

    /** @var string установленный язык */
    protected $lang;

    abstract public function getPath(): string;

    protected const DEFAULT_UNIT = [
        'ru' => 'ШТ',
    ];

    public function __construct(string $lang)
    {
        $this->lang = $lang;
        CatalogField::setLang($lang);
    }

    /**
     * Сопоставление ячеек полей
     * @return array
     */
    public function getFields(): array
    {
        return [

        ];
    }

    /**
     * Перебирает getFields и ищет в ключах шаблоны промежутков вида A:C и формирует новый список полей
     * @return array
     * @throws Exception
     */
    public function getCoordinate(): array
    {
        $coordinate = [];

        foreach ($this->getFields() as $key => $field) {
            /** @var CatalogType $field */
            $range = explode(':', $key);

            if (count($range) === 1) {
                $coordinate[$key] = $field;
            } elseif (count($range) === 2) {
                [$start, $end] = $range;

                $startIndex = Coordinate::columnIndexFromString($start);
                $endIndex = Coordinate::columnIndexFromString($end);

                for ($i = $startIndex; $i <= $endIndex; $i++) {
                    $coordinate[Coordinate::stringFromColumnIndex($i)] = $field;
                }
            }
        }

        return $coordinate;
    }

    /**
     * Отдает по имени полный путь до файла
     * @param string $name
     * @return string
     */
    public function getPathByName(string $name): string
    {
        $this->filename = $name;
        return $this->getResourcesDir() . DIRECTORY_SEPARATOR . $name;
    }

    /**
     * Строит путь до директории с файлами импорта
     * @param string $lang
     * @return string
     */
    protected function getResourcesDir(string $lang = 'ru'): string
    {
        return dirname(__DIR__, 3) . DIRECTORY_SEPARATOR . static::CATALOG_BASE_PATH . $lang . DIRECTORY_SEPARATOR . 'new';
    }

    /**
     * Возвращает имя файла указанный при инициализации ресурса
     * @return string
     */
    public function getFileName(): string
    {
        return $this->filename;
    }

    /**
     * Возвращает строку на которой находятся заголовки
     * @return int
     */
    public function getColumnTitleRow(): int
    {
        return static::COLUMN_TITLE_ROW;
    }

    /**
     * Возвращает название листа
     * @return string
     */
    public function getSheetName(): string
    {
        return $this->sheetName;
    }

}
