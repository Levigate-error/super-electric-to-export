<?php

namespace App\Utils\Files\Providers\Specification;

use App\Utils\Files\Notice\NoticeCollection;
use App\Utils\Files\Collections\Specification\SpecificationCollection;
use App\Utils\Files\Collections\Specification\SpecificationSheetCollection;
use Illuminate\Http\UploadedFile;
use App\Exceptions\WrongArgumentException;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\ServiceContracts\Project\ProjectSpecificationServiceContract;
use App\Domain\UtilContracts\Files\FilesProviderContract;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Utils\Files\Checkers\BaseChecker;
use App\Utils\Files\Checkers\Specification\Excel\SpreadsheetSheetExistingChecker;
use App\Utils\Files\Checkers\Specification\Excel\SpreadsheetHeadersChecker;
use App\Utils\Files\Checkers\Specification\Excel\ValuesChecker;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Utils\Files\Mappers\Specification\ExcelMapper;

/**
 * Class ExcelProvider
 * @package App\Utils\Files\Providers\Specification
 */
class ExcelProvider implements FilesProviderContract
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var ProjectServiceContract
     */
    protected $projectService;

    /**
     * @var ProjectSpecificationServiceContract
     */
    protected $projectSpecificationService;

    /**
     * @var ExcelMapper
     */
    protected $mapper;

    /**
     * ExcelProvider constructor.
     * @param array $config
     * @throws BindingResolutionException
     */
    public function __construct(array $config)
    {
        $this->projectService = app()->make(ProjectServiceContract::class);
        $this->projectSpecificationService = app()->make(ProjectSpecificationServiceContract::class);
        $this->config = $config;
        $this->mapper = new ExcelMapper();
    }

    /**
     * @param int $entityId
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function getEntityFileLink(int $entityId): string
    {
        $realFile = $this->generateEntityFile($entityId);

        return Storage::disk('public')->url($realFile);
    }

    /**
     * @param int $entityId
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function generateEntityFile(int $entityId): string
    {
        $project = $this->projectService->getRepository()->getSource()::query()->findOrFail($entityId);

        $spreadsheet = IOFactory::load(public_path() . $this->config['clean_blank_path']);

        $this->fillInProductsSheet($spreadsheet, $entityId);
        $this->fillInSpecificationSheet($spreadsheet, $entityId);

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $fileName = str_replace(' ', '_', $project->title) . '_specification_' . date('Ymd_His') . '.xlsx';
        $tempFile = config('projects.temp_directory') . $fileName;
        $realFile = $this->config['blanks_path'] . $fileName;

        $writer->save($tempFile);
        Storage::disk('public')->put($realFile, File::get($tempFile));
        File::delete($tempFile);

        return $realFile;
    }

    /**
     * Заполняем вкладку спецификации
     *
     * @param Spreadsheet $spreadsheet
     * @param int $entityId
     */
    protected function fillInSpecificationSheet(Spreadsheet $spreadsheet, int $entityId): void
    {
        $specificationSheet = $spreadsheet->getSheetByName($this->config['sheet_names']['specification']);
        if (!$specificationSheet) {
            throw new WrongArgumentException('Specification sheet does not exist');
        }

        $row = (int) $this->config['header_height'];

        $specification = $this->projectService->getProjectSpecifications($entityId);
        $sections = array_merge(
            $this->projectSpecificationService->getSectionWithNotUsedProductsBySpecification($specification['id'], true),
            $this->projectSpecificationService->getSpecificationSectionsList($specification['id'], true)
        );

        foreach($sections as $section) {
            foreach ($section['products'] as $product) {
                $row++;

                $productResource = [
                    'A' => [
                        'value' => $section['title'],
                        'type'  => DataType::TYPE_STRING,
                    ],
                    'B' => [
                        'value' => $product['product']['vendor_code'],
                        'type'  => DataType::TYPE_STRING,
                    ],
                    'C' => [
                        'value' => $product['product']['name'],
                        'type'  => DataType::TYPE_STRING,
                    ],
                    'D' => [
                        'value' => $product['in_stock'] ? __('project.file.in_stock_val') : __('project.file.not_in_stock_val'),
                        'type'  => DataType::TYPE_STRING,
                    ],
                    'E' => [
                        'value' => $product['amount'],
                        'type'  => DataType::TYPE_NUMERIC,
                    ],
                    'F' => [
                        'value' => $product['real_price'],
                        'type'  => DataType::TYPE_NUMERIC,
                    ],
                    'G' => [
                        'value' => $product['discount'],
                        'type'  => DataType::TYPE_NUMERIC,
                    ],
                    'H' => [
                        'value' => $product['price'],
                        'type'  => DataType::TYPE_NUMERIC,
                    ],
                    'I' => [
                        'value' => $product['total_price'],
                        'type'  => DataType::TYPE_NUMERIC,
                    ],
                ];

                $this->fillSheetRow($specificationSheet, $this->mapper->getMap('specification'), $productResource, $row);
            }
        }
    }

    /**
     * Заполняем вкладку с товарами
     *
     * @param Spreadsheet $spreadsheet
     * @param int $entityId
     */
    protected function fillInProductsSheet(Spreadsheet $spreadsheet, int $entityId): void
    {
        $productsSheet = $spreadsheet->getSheetByName($this->config['sheet_names']['products']);
        if (!$productsSheet) {
            throw new WrongArgumentException('Products sheet does not exist');
        }

        $projectProducts = $this->projectService->getProjectProducts($entityId, [], true);

        $row = (int) $this->config['header_height'];

        foreach($projectProducts as $projectProduct) {
            $row++;

            $productResource = [
                'A' => [
                    'value' => $projectProduct['vendor_code'],
                    'type'  => DataType::TYPE_STRING,
                ],
                'B' => [
                    'value' => $projectProduct['name'],
                    'type'  => DataType::TYPE_STRING,
                ],
                'C' => [
                    'value' => $projectProduct['amount'],
                    'type'  => DataType::TYPE_NUMERIC,
                ],
                'D' => [
                    'value' => $projectProduct['real_price'],
                    'type'  => DataType::TYPE_NUMERIC,
                ],
                'E' => [
                    'value' => $projectProduct['in_stock'] ? __('project.file.in_stock_val') : __('project.file.not_in_stock_val'),
                    'type'  => DataType::TYPE_STRING,
                ],
                'F' => [
                    'value' => $projectProduct['discount'],
                    'type'  => DataType::TYPE_NUMERIC,
                ],
                'G' => [
                    'value' => $projectProduct['price_with_discount'],
                    'type'  => DataType::TYPE_NUMERIC,
                ],
            ];

            $this->fillSheetRow($productsSheet, $this->mapper->getMap('products'), $productResource, $row);
        }
    }

    /**
     * По карте и ресурсу заполняет строку в листе
     *
     * @param Worksheet $sheet
     * @param array $map
     * @param array $resource
     * @param int $row
     */
    protected function fillSheetRow(Worksheet $sheet, array $map, array $resource, int $row): void
    {
        foreach ($map as $elementKey => $elementValue) {
            if (!isset($resource[$elementKey])) {
                continue;
            }

            $sheet->setCellValueExplicit(
                $elementKey . $row,
                $resource[$elementKey]['value'],
                $resource[$elementKey]['type']
            );
        }
    }

    /**
     * @param UploadedFile $file
     * @return NoticeCollection
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function checkFile(UploadedFile $file): NoticeCollection
    {
        $spreadsheet = IOFactory::load($file);

        return (new BaseChecker(
            new SpreadsheetSheetExistingChecker($this->config),
            new SpreadsheetHeadersChecker($this->config, $this->mapper),
            new ValuesChecker($this->config, $this->getFileData($file))
        ))->check($spreadsheet);
    }

    /**
     * @return string
     */
    public function getUrlOfFileExample(): string
    {
        return url($this->config['clean_blank_path']);
    }

    /**
     * @param UploadedFile $file
     * @return SpecificationCollection
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function getFileData(UploadedFile $file): SpecificationCollection
    {
        $fileData = new SpecificationCollection();
        $spreadsheet = IOFactory::load($file);

        foreach ($this->config['sheet_names'] as $sheetNameKey => $sheetNameValue) {
            $sheet = $spreadsheet->getSheetByName($sheetNameValue);

            if (!$sheet) {
                continue;
            }

            $fileData->offsetSet($sheetNameKey, $this->getSheetData($sheet, $sheetNameKey));
        }

        return $fileData;
    }

    /**
     * Собирает данные листа
     *
     * @param Worksheet $sheet
     * @param string $sheetNameKey
     * @return SpecificationSheetCollection
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getSheetData(Worksheet $sheet, string $sheetNameKey): SpecificationSheetCollection
    {
        $sheetData = new SpecificationSheetCollection();

        $highestRow = $sheet->getHighestRow('A');
        $startRow = (int) $this->config['header_height'] + 1;

        for ($rowNumber = $startRow; $rowNumber <= $highestRow; $rowNumber++) {
            $rowData = $this->getRowData($sheet, $sheetNameKey, $rowNumber);
            if (empty($rowData)) {
                continue;
            }

            $sheetData->push($rowData);
        }

        return $sheetData;
    }

    /**
     * По маперу собирает данные из строки
     *
     * @param Worksheet $sheet
     * @param string $sheetNameKey
     * @param int $rowNumber
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getRowData(Worksheet $sheet, string $sheetNameKey, int $rowNumber): array
    {
        $map = $this->mapper->getMap($sheetNameKey);

        $rowData = [];
        foreach ($map as $elementKey => $elementValue) {
            $cell = $sheet->getCell($elementKey . $rowNumber);

            if (!$cell) {
                continue;
            }

            $rowData[$elementValue] = $cell->getValue();
        }

        return $rowData;
    }
}
