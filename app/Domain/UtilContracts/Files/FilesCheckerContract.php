<?php

namespace App\Domain\UtilContracts\Files;

use App\Utils\Files\Notice\NoticeCollection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

/**
 * Interface FilesCheckerContract
 * @package App\Domain\UtilContracts\Files
 */
interface FilesCheckerContract
{
    /**
     * @param Spreadsheet $spreadsheet
     * @return NoticeCollection
     */
    public function check(Spreadsheet $spreadsheet): NoticeCollection;
}
