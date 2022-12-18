<?php


namespace Database\Seeds\Import\Catalog\Resources;

use Database\Seeds\Import\Catalog\CatalogField;

class CatalogNetatmo extends BaseResource
{
    /** @var string название листа */
    protected $sheetName = 'Sheet1';

    /**
     * Сопоставление ячеек полей, имеется поддержка промежутка столбцов A:C
     * Так же можно вызвать функцию обратного вывова и вернуть тип поля и установить значение из другого столбца:
     * static function(array $row) {
     *   return CatalogField::familyCode()->value($row['C']);
     * },
     * @return array
     */
    public function getFields(): array
    {
        return [
            //товарная группа
            'A' => CatalogField::category(),
            //признак изделия
            'B' => CatalogField::division(),
            'C' => CatalogField::familyName(),
            'D' => CatalogField::vendorCode(),
            'E' => CatalogField::name(),
            'F' => CatalogField::recommendedRetailPrice(),
            'G' => CatalogField::minAmount(),
            'H' => CatalogField::unit(static::DEFAULT_UNIT[$this->lang]),
            //коммерческие страницы
            'I' => CatalogField::commercialPage(),
            //инструкции
            'J' => CatalogField::instruction(),
            //сертификаты
            'K:M' => CatalogField::certificate(null, true),
            //видео
            'N:Q' => CatalogField::video(),
            //изображения
            'R:AD' => CatalogField::image(),
            //своства товара
            'AE:BA' => CatalogField::property(),
            static function (array $row) {
                return CatalogField::familyCode()->value($row['C']);
            },
            static function () {
                return CatalogField::familyNumber()->value('');
            },
        ];
    }


    /**
     * Возвращает путь к файла по имени файла
     * @return string
     */
    public function getPath(): string
    {
        return $this->getPathByName('Суперэлектрик Netatmo обновлённый 28.04.20.xlsx');
    }
}
