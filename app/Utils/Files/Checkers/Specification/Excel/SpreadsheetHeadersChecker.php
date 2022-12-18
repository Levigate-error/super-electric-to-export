<?php

namespace App\Utils\Files\Checkers\Specification\Excel;

use App\Domain\UtilContracts\Files\FilesCheckerContract;
use App\Utils\Files\Notice\Notice;
use App\Utils\Files\Notice\NoticeCollection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Domain\Dictionaries\Files\NoticeDictionary;
use App\Utils\Files\Mappers\Specification\ExcelMapper;

/**
 * Class SpreadsheetHeadersChecker
 * @package App\Utils\Files\Checkers\ProjectSpecification\Excel
 */
class SpreadsheetHeadersChecker implements FilesCheckerContract
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
     */
    public function check(Spreadsheet $spreadsheet): NoticeCollection
    {
        $noticeCollection = new NoticeCollection();
        $headerTitleRow = $this->config['header_height'];

        foreach ($this->config['sheet_names'] as $sheetNameKey => $sheetNameValue) {
            $sheet = $spreadsheet->getSheetByName($sheetNameValue);

            $expectationErrors = collect($this->getSheetExpectationHeader($sheetNameKey, $headerTitleRow))
                ->reject(static function($value, $key) use ($sheet) {
                    return $sheet->getCell($key)->getValue() === $value;
                });

            if ($expectationErrors->isNotEmpty()) {
                $noticeCollection->push(new Notice(
                    NoticeDictionary::LEVEL_CRITICAL,
                    __('project.upload_notices.invalid_spreadsheet_headers'),
                    $expectationErrors->map(static function($value, $key) use ($sheet) {
                        return __('project.upload_notices.spreadsheet_cell_unexpected_value', [
                            'cell' => $key,
                            'expectation' => $value,
                            'reality' => $sheet->getCell($key)->getValue()
                        ]);
                    })->implode("\n")
                ));
            }
        }

        return $noticeCollection;
    }

    /**
     * Получить "адрес" ячейки и ее значение для заголовков столбцов
     *
     * @param string $sheetNameKey
     * @param int $headerRow
     * @return array
     */
    private function getSheetExpectationHeader(string $sheetNameKey, int $headerRow): array
    {
        $expectationHeader = [];

        foreach ($this->mapper->getMap($sheetNameKey) as $elementKey => $elementValue) {
            $expectationHeader[$elementKey . $headerRow] = __("project.file.$elementValue");
        }

        return $expectationHeader;
    }
}
