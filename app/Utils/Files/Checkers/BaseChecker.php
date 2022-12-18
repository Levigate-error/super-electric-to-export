<?php

namespace App\Utils\Files\Checkers;

use App\Domain\UtilContracts\Files\FilesCheckerContract;
use App\Utils\Files\Notice\NoticeCollection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class BaseChecker
{
    /**
     * @var FilesCheckerContract[]
     */
    protected $checkers;

    /**
     * BaseChecker constructor.
     * @param FilesCheckerContract ...$checkers
     */
    public function __construct(FilesCheckerContract ...$checkers)
    {
        $this->checkers = $checkers;
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @return NoticeCollection
     */
    public function check(Spreadsheet $spreadsheet): NoticeCollection
    {
        $noticeCollection = new NoticeCollection();

        foreach ($this->checkers as $checker) {
            $noticeCollection = $noticeCollection->merge($checker->check($spreadsheet));

            if ($noticeCollection->hasCritical()) {
                break;
            }
        }

        return $noticeCollection;
    }
}
