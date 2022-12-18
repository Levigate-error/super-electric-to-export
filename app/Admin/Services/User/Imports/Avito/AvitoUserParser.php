<?php

namespace App\Admin\Services\User\Imports\Avito;

use App\Domain\ServiceContracts\Imports\Avito\AvitoUserParserContract;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Throwable;

/**
 * Class AvitoImportParser
 *
 * Парсер выгрузки юзеров Авито.
 *
 * @package App\Admin\Services\User\Imports\Avito
 */
class AvitoUserParser implements AvitoUserParserContract
{
    protected const HEADER_ROW = 1;

    /**
     * {@inheritDoc}
     *
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function parse(string $fileName): AvitoUserCollection
    {
        $file = storage_path('app' . DIRECTORY_SEPARATOR . $fileName);

        $spreadsheet = IOFactory::load($file);

        $sheets = $spreadsheet->getAllSheets();

        $avitoUserCollection = new AvitoUserCollection();

        foreach ($sheets as $sheet) {
            $highestRow = $sheet->getHighestRow('A');
            $startRow = self::HEADER_ROW + 1;

            for ($rowNumber = $startRow; $rowNumber <= $highestRow; $rowNumber++) {
                try {
                    $avitoUser = new AvitoUser(
                        $this->getCellValue($sheet, "A$rowNumber"),
                        $this->getCellValue($sheet, "B$rowNumber"),
                        $this->getCellValue($sheet, "C$rowNumber"),
                        $this->getCellValue($sheet, "D$rowNumber")
//                        $this->getCellValue($sheet, "E$rowNumber"),
//                        $this->getCellValue($sheet, "F$rowNumber"),
//                        $this->getCellValue($sheet, "G$rowNumber")
                    );
                } catch (Throwable $exception) {
                    Log::error($exception->getMessage());
                    continue;
                }

                $avitoUserCollection->addElement($avitoUser);
            }
        }

        return $avitoUserCollection;
    }

    /**
     * Получить значение ячейки.
     *
     * @param Worksheet $sheet
     * @param string    $pCoordinate
     *
     * @return string
     * @throws Exception
     */
    protected function getCellValue(Worksheet $sheet, string $pCoordinate): string
    {
        $cell = $sheet->getCell($pCoordinate);

        if ($cell === null) {
            throw new InvalidArgumentException('Invalid pCoordinate');
        }

        return $cell->getValue();
    }
}
