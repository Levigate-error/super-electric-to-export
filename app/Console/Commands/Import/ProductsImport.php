<?php

namespace App\Console\Commands\Import;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDivision;
use App\Models\ProductFamily;
use App\Models\ProductFeatureType;
use App\Models\ProductFeatureTypesDivisions;
use App\Models\ProductFeatureTypesValues;
use App\Models\ProductFeatureValue;
use App\Models\ProductFiles;
use Database\Seeds\Helpers\CatalogExternalResources;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class ProductsImport
 * @package App\Console\Commands\Import
 */
class ProductsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products {--file= : File in storage/app/import/products/retail/}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products from file';

    protected $file = 'https://project.legrand.ru/legrand/Retail/XLS_summary/FullItemList.xlsx';
    protected $fileName = 'FullItemList.xlsx';

    protected $url = 'https://project.legrand.ru/legrand/Retail/XLS_summary/';
    protected $files = [
        '0010_Электроустановочное_оборудование.xlsx',
        '0020_Модульное_оборудование.xlsx',
        '0030_Щитки_распределительные.xlsx',
        '0040_Удлинители.xlsx',
        '0050_Мобильные_устройства_подключения.xlsx',
        '0060_Звонки.xlsx',
	    '0070_Датчики_движения.xlsx',
        '0080_Монтажные_коробки_(подрозетники)_.xlsx',
        '0090_Силовые_розетки_20_32А.xlsx',
	    '0100_Промышленные_разъёмы.xlsx',
	    '0110_Кабельные_каналы.xlsx',
	    '0120_Коробка_распределительная_IP55_.xlsx',
	    '0130_Источники_бесперебойного_питания.xlsx',
	    '0140_Встраиваемые_блоки_IP44_.xlsx',
	    '0150_Выдвижные_розеточные_блоки.xlsx',
	    '0160_Настольные_розеточные_блоки.xlsx',
	    '0180_Коробки_напольные.xlsx',
	    '0190_Колонны_и_мини-колонны.xlsx',
	    '0200_Маркировка_кабельная_.xlsx',
	    '0210_Хомуты.xlsx',
	    '0220_Кабельные_наконечники.xlsx',
	    '0230_Перфокороба_монтажные.xlsx',
	    '0240_Кабельная_система.xlsx',
	    '0250_Домашняя_автоматизация.xlsx'
    ];

    protected const CATEGORIES_IN_MAIN = 2;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start products import');
        $files = [];
        if ($this->option('file') !== null) {
            $this->file = $this->option('file');
            $this->fileName = basename($this->file);
            if ($path = $this->getFile($this->file, $this->fileName)) {
                $files = [ $this->fileName => $path ];
            }
        } else {
            $files = $this->getFiles();
        }

        if (!$files) {
            $this->info('Error with get files');
            return false;
        }

        $resourcesHelper = new CatalogExternalResources();

        $products = $resourcesHelper->getProductsFromFiles($files);

        $categories = $this->updateCategories($products);
        $divisions = $this->updateDivisions($products);
        $families = $this->updateFamilies($products);

        $this->updateProducts($products, $divisions, $categories, $families);
        $this->info('Done products import');

        return true;
    }

    /**
     * Получение директории для сохранения файлов
     *
     * @return string
     * @throws Exception
     */
    protected function getResourcesDir(): string
    {
        $filePath = storage_path('app' . DIRECTORY_SEPARATOR . 'import' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR . 'retail' . DIRECTORY_SEPARATOR);
        if (!file_exists($filePath)) {
            mkdir($filePath, 0775, true);
            if (!is_writable($filePath)) {
                throw new Exception("Directory is not writable");
            }
        }
        return $filePath;
    }

    /**
     * Получение файлов по умолчанию
     *
     * @return array
     */
    protected function getFiles(): array
    {
        $filePath = [];
        foreach ($this->files as $file) {
            if ($path = $this->getFile($this->url . DIRECTORY_SEPARATOR . $file, $file)) {
                $filePath[$file] = $path;
            }
        }
        return $filePath;
    }


    /**
     * Получение файла по ссылке и сохрание
     *
     * @param string $file
     * @param string $fileName
     *
     * @return string
     */
    protected function getFile(string $file, string $fileName): string
    {
        $filePath = $this->getResourcesDir();

        $client = new GuzzleClient();

        $response = $client->request('GET', $file, [
            'sink' => $filePath . $fileName
        ]);

        if ($response->getStatusCode() !== 200) {
            return '';
        }

        return $filePath . $fileName;
    }

    /**
     * Обновление продуктов
     *
     * @param array $products
     * @param array $divisions
     * @param array $categories
     * @param array $families
     *
     * @throws Exception
     */
    protected function updateProducts(array $products, array $divisions, array $categories, array $families): void
    {
        $this->info('Update products');

        $productsCount = count($products);
        $this->info('Products count: ' . $productsCount);

        $progressBar = new ProgressBar($this->output);
        $progressBar->start($productsCount);

        foreach ($products as $product) {
            if (empty($product['vendor_code'])) {
                continue;
            }

            $currentProduct = Product::query()->where('vendor_code', $product['vendor_code'])->first();

            if (!$currentProduct) {
                $currentProduct = new Product();
            }

            $this->fillProduct($currentProduct, $product, $divisions, $categories, $families);

            if ($currentProduct->isDirty()) {
                $currentProduct->trySaveModel();
            }

            $this->addFiles($currentProduct, $product['files']);
            $this->addProperties($currentProduct, $product['properties']);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info(PHP_EOL . 'Done');
    }

    /**
     * Заполнение записи данными
     *
     * @param Product $product
     * @param array $productInfo
     * @param ProductDivision[] $divisions
     * @param ProductCategory[] $categories
     * @param ProductFamily[] $families
     */
    protected function fillProduct(Product $product, array $productInfo, array $divisions, array $categories, array $families): void
    {
        $product->fill(Arr::only($productInfo, Product::PRODUCT_DATA));

        $product->name = $this->encodeTranslates(['ru' => $productInfo['name']]);
        $product->unit = $this->encodeTranslates(['ru' => $productInfo['unit']]);

        //лара хранит unsignedFloat данные в строках. Чтобы работало isDirty - форматируем в строку.
        $product->recommended_retail_price = number_format($productInfo['recommended_retail_price'], 2, '.', '');

        $productCategory = $categories[$productInfo['category']];
        $productDivision = $divisions[$productInfo['division'] . '-' . $productInfo['category']];
        $productFamily = $families[$productInfo['family_code']];

        $product->category_id = $productCategory->id;
        $product->division_id = $productDivision->id;
        $product->family_id = $productFamily->id;

        if ($productFamily->code === 'SER075') {
            $product->is_loyalty = true;
        }
    }


    /**
     * Обновление подкатегорий продуктов (признак изделия)
     *
     * @param array $products
     *
     * @return array
     * @throws Exception
     */
    protected function updateDivisions(array $products): array
    {
        $this->info('Updating Divisions');
        $divisions = [];

        foreach ($products as $product) {
            $currentCategory = ProductCategory::query()->where('name->ru', $product['category'])->first();
            if (!$currentCategory) {
                continue;
            }

            $divisionName = $product['division'];
            $new = false;
            $currentDivision = ProductDivision::query()->where([
                'name->ru' =>  $divisionName,
                'category_id' => $currentCategory->id,
            ])->first();

            if (!$currentDivision) {
                $new = true;
                $currentDivision = new ProductDivision();
                $currentDivision::unguard();
            }

            $currentDivision->fill([
                'name' => $this->encodeTranslates(['ru' => $divisionName]),
                'category_id' => $currentCategory->id,
            ]);
            $currentDivision->trySaveModel();
            if ($new) {
                $currentDivision::reguard();
            }

            $divisionCategoryName = $this->translate($currentDivision->category->name);
            $divisions["$divisionName-$divisionCategoryName"] = $currentDivision;
        }

        $this->info('Done');
        return $divisions;
    }

    /**
     * Обновление категорий продуктов (товарная группа)
     *
     * @param array $products
     *
     * @return array
     * @throws Exception
     */
    protected function updateCategories(array $products): array
    {
        $this->info('Updating Categories');
        $categories = [];
        $categoriesNames = array_values(array_filter(array_unique(array_column($products,'category'))));

        $existedCategories = [];
        foreach (ProductCategory::query()->whereIn('name->ru', $categoriesNames)->get() as $existedCategory) {
            $currentCategoryName = $this->translate($existedCategory->name);

            $existedCategories[] = $currentCategoryName;
            $categories[$currentCategoryName] = $existedCategory;
        }

        $notExistedCategories = array_diff($categoriesNames, $existedCategories);
        $categoriesInMain = 0;
        foreach ($notExistedCategories as $categoryName) {
            $category = new ProductCategory();

            $category->fill([
                'name' => $this->encodeTranslates(['ru' => $categoryName]),
            ]);

            if ($categoriesInMain < static::CATEGORIES_IN_MAIN) {
                $category->in_main = true;
                $categoriesInMain++;
            }

            $category->trySaveModel();

            $categories[$categoryName] = $category;
        }

        $this->info('Done');
        return $categories;
    }

    /**
     * Обновление семейств продуктов
     *
     * @param array $products
     *
     * @return array
     * @throws Exception
     */
    protected function updateFamilies(array $products): array
    {
        $this->info('Updating Families');
        $families = [];

        $familiesInfo = [];
        foreach ($products as $product) {
            if (empty($product['family_code'])) {
                continue;
            }

            $familiesInfo[$product['family_code']] = [
                'code' => $product['family_code'],
                'name' => $product['family_name'],
                'number' => $product['family_number'],
            ];
        }

        $existedFamilies = [];
        foreach (ProductFamily::query()->whereIn('code', array_keys($familiesInfo))->get() as $existedFamily) {
            $existedFamilies[] = $existedFamily->code;
            $families[$existedFamily->code] = $existedFamily;
        }

        $notExistedFamilies = array_diff(array_keys($familiesInfo), $existedFamilies);
        foreach ($notExistedFamilies as $familyCode) {
            $family = new ProductFamily();
            $family::unguard();

            $family->fill([
                'code' => $familyCode,
                'name' => $this->encodeTranslates(['ru' => $familiesInfo[$familyCode]['name']]),
                'number' => $familiesInfo[$familyCode]['number'],
            ]);
            $family->trySaveModel();
            $family::reguard();

            $families[$familyCode] = $family;
        }

        $this->info('Done');
        return $families;
    }

    /**
     * Добавление файлов к продукту
     *
     * @param Product $product
     * @param array   $files
     *
     * @throws Exception
     */
    protected function addFiles(Product $product, array $files)
    {
        $product->files()->delete();

        foreach ($files as $file) {
            if ($this->validateFile($file) === false) {
                continue;
            }

            $productFile = new ProductFiles();
            $productFile::unguard();
            $productFile->fill([
                'product_id' => $product->id,
                'type' => $file['type'],
                'file_link' => $file['file_link'],
                'description' => $this->encodeTranslates(['ru' => $file['description']]),
                'comment' => $this->encodeTranslates(['ru' => $file['comment']]),
            ]);
            $productFile->trySaveModel();
            $productFile::reguard();
        }
    }

    /**
     * @param  array  $file
     *
     * @return bool
     */
    protected function validateFile(array $file): bool
    {
        if (empty($file['file_link']) || empty($file['type'])) {
            return false;
        }

        if (Str::length($file['type']) > 32) {
            return false;
        }

        return true;
    }

    /**
     * Добавление свойств подкатегории товара
     *
     * @param Product $product
     * @param array   $properties
     *
     * @throws Exception
     */
    protected function addProperties(Product $product, array $properties)
    {
        $product->featureTypesValues()->delete();

        foreach ($properties as $property) {
            if (empty($property['title'])) {
                continue;
            }

            if ($property['title'] === 'Подробное описание товара') {
                $product->setAttribute('description', $this->encodeTranslates(['ru' => $property['value']]));
                $product->trySaveModel();
                continue;
            }

            $productDivisionId = $product->division_id;

            $currentFeatureType = ProductFeatureType::query()->where('name->ru', $property['title'])->first();
            if (!$currentFeatureType) {
                $currentFeatureType = new ProductFeatureType();
                $currentFeatureType::unguard();
                $currentFeatureType->fill([
                    'name' => $this->encodeTranslates(['ru' => $property['title']]),
                ]);
                $currentFeatureType->trySaveModel();
                $currentFeatureType::reguard();
            }

            $currentFeatureValue = $currentFeatureType->values()->where('value->ru', $property['value'])->first();
            if (!$currentFeatureValue) {
                $currentFeatureValue = new ProductFeatureValue();
                $currentFeatureValue::unguard();
                $currentFeatureValue->fill([
                    'value' => $this->encodeTranslates(['ru' => $property['value']]),
                    'product_feature_type_id' => $currentFeatureType->id,
                ]);
                $currentFeatureValue->trySaveModel();
                $currentFeatureValue::reguard();
            }

            $currentFeatureTypesDivisions = $currentFeatureType->typesDivisions()->where("product_division_id", $productDivisionId)->first();
            if (!$currentFeatureTypesDivisions) {
                $currentFeatureTypesDivisions = new ProductFeatureTypesDivisions();
                $currentFeatureTypesDivisions::unguard();
                $currentFeatureTypesDivisions->fill([
                    'product_feature_type_id' => $currentFeatureType->id,
                    'product_division_id' => $productDivisionId,
                ]);
                $currentFeatureTypesDivisions->trySaveModel();
                $currentFeatureTypesDivisions::reguard();
            }

            $currentFeatureTypesValues = ProductFeatureTypesValues::query()->where([
                'product_id' => $product->id,
                'product_feature_type_id' => $currentFeatureType->id,
                'product_feature_value_id' => $currentFeatureValue->id,
            ])->first();

            if (!$currentFeatureTypesValues) {
                $currentFeatureTypesValues = new ProductFeatureTypesValues();
                $currentFeatureTypesValues::unguard();
                $currentFeatureTypesValues->fill([
                    'product_id' => $product->id,
                    'product_feature_type_id' => $currentFeatureType->id,
                    'product_feature_value_id' => $currentFeatureValue->id,
                ]);
                $currentFeatureTypesValues->trySaveModel();
                $currentFeatureTypesValues::reguard();
            }
        }
    }

    /**
     * @param string $field
     * @param string $lang
     *
     * @return string
     */
    protected function translate(string $field, string $lang = 'ru'): string
    {
        $decode = json_decode($field, true);

        return $decode[$lang] ?? '';
    }

    /**
     * @param array $fields
     *
     * @return false|string
     */
    protected function encodeTranslates(array $fields)
    {
        return json_encode($fields);
    }
}
