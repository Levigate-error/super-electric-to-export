<?php

namespace App\Utils\Files\Checkers\Specification\Excel;

use App\Domain\UtilContracts\Files\FilesCheckerContract;
use App\Utils\Files\Notice\Notice;
use App\Utils\Files\Notice\NoticeCollection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Domain\Dictionaries\Files\NoticeDictionary;
use App\Utils\Files\Mappers\Specification\ExcelMapper;

/**
 * Class ProductCountChecker
 * @package App\Utils\Files\Checkers\Specification\Excel
 */
class ProductCountChecker implements FilesCheckerContract
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var ExcelMapper
     */
    protected $mapper;

    /**
     * SpreadsheetHeadersChecker constructor.
     * @param array $config
     * @param ExcelMapper $mapper
     */
    public function __construct(array $config, ExcelMapper $mapper)
    {
        $this->config = $config;
        $this->mapper = $mapper;
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @return NoticeCollection
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function check(Spreadsheet $spreadsheet): NoticeCollection
    {
        $noticeCollection = new NoticeCollection();

        $errors = collect($this->getVendorCodeWithCounts($spreadsheet))
            ->filter(static function($value, $key) {
                if (isset($value['specification'], $value['products'])) {
                    return $value['products'] < $value['specification'];
                }
            });

        if ($errors->isNotEmpty()) {
            $noticeCollection->push(new Notice(
                NoticeDictionary::LEVEL_CRITICAL,
                __('project.upload_notices.invalid_product_amount'),
                $errors->map(static function($value, $key) {
                    return __('project.upload_notices.details_product_amount', [
                        'vendor_code' => $key,
                    ]);
                })->implode("\n")
            ));
        }

        return $noticeCollection;
    }

    /**
     * Формирует массив артикулов товаров с их кол-ством на вкладках
     *
     * @param Spreadsheet $spreadsheet
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getVendorCodeWithCounts(Spreadsheet $spreadsheet): array
    {
        $productsCount = [];

        foreach ($this->config['sheet_names'] as $sheetNameKey => $sheetNameValue) {
            $sheet = $spreadsheet->getSheetByName($sheetNameValue);

            $countCellLitter = $this->mapper->getKeyByValue($sheetNameKey, 'amount');
            $vendorCodeCellLitter = $this->mapper->getKeyByValue($sheetNameKey, 'vendor_code');
            $sectionCodeCellLitter = $this->mapper->getKeyByValue($sheetNameKey, 'section');

            $highestRow = $sheet->getHighestRow('A');
            $startRow = (int) $this->config['header_height'] + 1;

            for ($rowNumber = $startRow; $rowNumber <= $highestRow; $rowNumber++) {
                /**
                 * Если есть название раздела спеки, то не учитываем, если это нераспределенная продукция
                 */
                if ($sectionCodeCellLitter) {
                    $section = $sheet->getCell($sectionCodeCellLitter . $rowNumber)->getValue();

                    if ($section === __('project.fake_section')) {
                        continue;
                    }
                }

                $count = (int) $sheet->getCell($countCellLitter . $rowNumber)->getValue();
                $vendorCode = $sheet->getCell($vendorCodeCellLitter . $rowNumber)->getValue();

                if (!isset($productsCount[$vendorCode][$sheetNameKey])) {
                    $productsCount[$vendorCode][$sheetNameKey] = 0;
                }

                $productsCount[$vendorCode][$sheetNameKey] += $count;
            }
        }

        return $productsCount;
    }
}
