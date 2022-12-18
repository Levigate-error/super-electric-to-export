<?php

namespace App\Utils\Files\Checkers\Specification\Excel;

use App\Domain\UtilContracts\Files\FilesCheckerContract;
use App\Utils\Files\Collections\Specification\SpecificationCollection;
use App\Utils\Files\Collections\Specification\SpecificationSheetCollection;
use App\Utils\Files\Notice\Notice;
use App\Utils\Files\Notice\NoticeCollection;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Domain\Dictionaries\Files\NoticeDictionary;
use App\Utils\Files\Validators\Specification\ProductValidator;

/**
 * Валидирует ячейке в загружаемом файле спецификации
 *
 * Class ValuesChecker
 * @package App\Utils\Files\Checkers\Specification\Excel
 */
class ValuesChecker implements FilesCheckerContract
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var SpecificationSheetCollection|null
     */
    protected $products;

    /**
     * ValuesChecker constructor.
     * @param array $config
     * @param SpecificationCollection $dataCollection
     */
    public function __construct(array $config, SpecificationCollection $dataCollection)
    {
        $this->config = $config;

        if ($dataCollection->has('products') === true) {
            $this->products = $dataCollection->get('products');
        }
    }

    /**
     * @param Spreadsheet $spreadsheet
     * @return NoticeCollection
     */
    public function check(Spreadsheet $spreadsheet): NoticeCollection
    {
        $noticeCollection = new NoticeCollection();



        $errorsCollection = $this->getFileProductsErrors();

        foreach ($errorsCollection as $error) {
            $errorsComments = collect($error['errors'])->map(static function ($value, $key) {
                return __("project.upload_notices.invalid_product_data_$value");
            })->implode("\n");

            $noticeCollection->push(new Notice(
                NoticeDictionary::LEVEL_CRITICAL,
                __('project.upload_notices.invalid_product_data', ['row' => $error['row']]),
                $errorsComments
            ));
        }

        return $noticeCollection;
    }

    /**
     * Собираем ошибки данных товара
     *
     * @return Collection
     */
    public function getFileProductsErrors(): Collection
    {
        $errorsCollection = new Collection();

        if ($this->products === null) {
            return $errorsCollection;
        }

        $productValidator = new ProductValidator();
        $rowNumber = 1 + $this->config['header_height'];

        foreach ($this->products as $product) {
            $errors = $productValidator->validate($product);

            if (empty($errors) === false) {
                $errorsCollection->push([
                    'row' => $rowNumber,
                    'errors' => $errors,
                ]);
            }

            $rowNumber++;
        }

        return $errorsCollection;
    }
}
