<?php

namespace App\Utils\Files\Checkers\Specification\Excel;

use App\Domain\UtilContracts\Files\FilesCheckerContract;
use App\Utils\Files\Notice\Notice;
use App\Utils\Files\Notice\NoticeCollection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Domain\Dictionaries\Files\NoticeDictionary;

/**
 * Class SpreadsheetSheetExistingChecker
 * @package App\Utils\Files\Checkers\ProjectSpecification\Excel
 */
class SpreadsheetSheetExistingChecker implements FilesCheckerContract
{
    /**
     * @var array
     */
    protected $config;

    /**
     * SpreadsheetSheetExistingChecker constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @return NoticeCollection
     */
    public function check(Spreadsheet $spreadsheet): NoticeCollection
    {
        $noticeCollection = new NoticeCollection();

        foreach ($this->config['sheet_names'] as $sheetName) {
            if (!$spreadsheet->getSheetByName($sheetName)) {
                $noticeCollection->push(new Notice(
                    NoticeDictionary::LEVEL_CRITICAL,
                    __('project.upload_notices.spreadsheet_sheet_doesnt_exists', [
                        'sheet_name' => $sheetName
                    ])
                ));
            }
        }

        return $noticeCollection;
    }
}
