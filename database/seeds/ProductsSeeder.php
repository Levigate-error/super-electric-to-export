<?php

use App\Models\ProductFeatureTypesDivisions;
use Illuminate\Database\Seeder;
use App\Models\ProductDivision;
use App\Models\ProductCategory;
use App\Models\ProductFamily;
use App\Models\Product;
use App\Models\ProductFeatureType;
use App\Models\ProductFeatureValue;
use App\Models\ProductFiles;
use App\Models\ProductFeatureTypesValues;
use Database\Seeds\Helpers\CatalogResources as ResourcesHelper;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class ProductsSeeder
 */
class ProductsSeeder extends Seeder
{
    protected const LANG = 'ru';
    protected const CATEGORIES_IN_MAIN = 2;

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function run()
    {
        $resourcesHelper = new ResourcesHelper();

        $products = $resourcesHelper->getProductsFromFiles($this->command, self::LANG);

        $categories = $this->updateCategories($products);
        $divisions = $this->updateDivisions($products);
        $families = $this->updateFamilies($products);

        $this->updateProducts($products, $divisions, $categories, $families);

        $this->command->line('');
    }

    /**
     * @param array $products
     * @param array $divisions
     * @param array $categories
     * @param array $families
     *
     * @throws Exception
     */
    protected function updateProducts(array $products, array $divisions, array $categories, array $families): void
    {
        $this->command->line('<comment>Update products </comment>');

        $productsCount = count($products);
        $this->command->line('Products count: ' . $productsCount);

        $progressBar = new ProgressBar($this->command->getOutput());
        $progressBar->start($productsCount);

        foreach ($products as $product) {
            if (empty($product['vendor_code'])) {
                continue;
            }

            $currentProduct = Product::query()->where('vendor_code', $product['vendor_code'])->get()->first();

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
        $this->command->info('Done');
    }

    /**
     * @param Product $product
     * @param array $productInfo
     * @param ProductDivision[] $divisions
     * @param ProductCategory[] $categories
     * @param ProductFamily[] $families
     */
    protected function fillProduct(Product $product, array $productInfo, array $divisions, array $categories, array $families): void
    {
        $product->fill(Arr::only($productInfo, Product::PRODUCT_DATA));

        $product->name = $this->encodeTranslates([self::LANG => $productInfo['name']]);
        $product->unit = $this->encodeTranslates([self::LANG => $productInfo['unit']]);

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
     * @param array $products
     *
     * @return array
     * @throws Exception
     */
    protected function updateDivisions(array $products): array
    {
        $this->command->line('<comment>Updating Divisions </comment>');
        $divisions = [];

        foreach ($products as $product) {
            $currentCategory = ProductCategory::query()->where('name->'. self::LANG, $product['category'])->get()->first();

            if (!$currentCategory) {
                continue;
            }

            $divisionName = $product['division'];
            $currentDivision = ProductDivision::query()->where([
                'name->'. self::LANG =>  $divisionName,
                'category_id' => $currentCategory->id,
            ])->get()->first();

            if (!$currentDivision) {
                $currentDivision = new ProductDivision();
            }

            $currentDivision->fill([
                'name' => $this->encodeTranslates([self::LANG => $divisionName]),
                'category_id' => $currentCategory->id,
            ]);
            $currentDivision->trySaveModel();

            $divisionCategoryName = $this->translate($currentDivision->category->name);
            $divisions["$divisionName-$divisionCategoryName"] = $currentDivision;
        }

        $this->command->info('Done');
        return $divisions;
    }

    /**
     * @param array $products
     *
     * @return array
     * @throws Exception
     */
    protected function updateCategories(array $products): array
    {
        $this->command->line('<comment>Updating Categories </comment>');
        $categories = [];
        $categoriesNames = array_values(array_filter(array_unique(array_column($products,'category'))));

        $existedCategories = [];
        foreach (ProductCategory::query()->whereIn('name->'. static::LANG, $categoriesNames)->get() as $existedCategory) {
            $currentCategoryName = $this->translate($existedCategory->name);

            $existedCategories[] = $currentCategoryName;
            $categories[$currentCategoryName] = $existedCategory;
        }

        $notExistedCategories = array_diff($categoriesNames, $existedCategories);
        $categoriesInMain = 0;
        foreach ($notExistedCategories as $categoryName) {
            $category = new ProductCategory();

            $category->fill([
                'name' => $this->encodeTranslates([self::LANG => $categoryName]),
            ]);

            if ($categoriesInMain < static::CATEGORIES_IN_MAIN) {
                $category->in_main = true;
                $categoriesInMain++;
            }

            $category->trySaveModel();

            $categories[$categoryName] = $category;
        }

        $this->command->info('Done');
        return $categories;
    }

    /**
     * @param array $products
     *
     * @return array
     * @throws Exception
     */
    protected function updateFamilies(array $products): array
    {
        $this->command->line('<comment>Updating Families </comment>');
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

            $family->fill([
                'code' => $familyCode,
                'name' => $this->encodeTranslates([self::LANG => $familiesInfo[$familyCode]['name']]),
                'number' => $familiesInfo[$familyCode]['number'],
            ]);
            $family->trySaveModel();

            $families[$familyCode] = $family;
        }

        $this->command->info('Done');
        return $families;
    }

    /**
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
            $productFile->fill([
                'product_id' => $product->id,
                'type' => $file['type'],
                'file_link' => $file['file_link'],
                'description' => $this->encodeTranslates([self::LANG => $file['description']]),
                'comment' => $this->encodeTranslates([self::LANG => $file['comment']]),
            ]);
            $productFile->trySaveModel();
        }
    }

    /**
     * @param  array  $file
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
                $product->setAttribute('description', $this->encodeTranslates([self::LANG => $property['value']]));
                $product->trySaveModel();
                continue;
            }

            $productDivisionId = $product->division_id;

            $currentFeatureType = ProductFeatureType::query()->where("name->" . self::LANG, $property['title'])->get()->first();
            if (!$currentFeatureType) {
                $currentFeatureType = new ProductFeatureType();
                $currentFeatureType->fill([
                    'name' => $this->encodeTranslates([self::LANG => $property['title']]),
                ]);
                $currentFeatureType->trySaveModel();
            }

            $currentFeatureValue = $currentFeatureType->values()->where("value->" . self::LANG, $property['value'])->get()->first();
            if (!$currentFeatureValue) {
                $currentFeatureValue = new ProductFeatureValue();
                $currentFeatureValue->fill([
                    'value' => $this->encodeTranslates([self::LANG => $property['value']]),
                    'product_feature_type_id' => $currentFeatureType->id,
                ]);
                $currentFeatureValue->trySaveModel();
            }

            $currentFeatureTypesDivisions = $currentFeatureType->typesDivisions()->where("product_division_id", $productDivisionId)->get()->first();
            if (!$currentFeatureTypesDivisions) {
                $currentFeatureTypesDivisions = new ProductFeatureTypesDivisions();
                $currentFeatureTypesDivisions->fill([
                    'product_feature_type_id' => $currentFeatureType->id,
                    'product_division_id' => $productDivisionId,
                ]);
                $currentFeatureTypesDivisions->trySaveModel();
            }

            $currentFeatureTypesValues = ProductFeatureTypesValues::query()->where([
                'product_id' => $product->id,
                'product_feature_type_id' => $currentFeatureType->id,
                'product_feature_value_id' => $currentFeatureValue->id,
            ])->get()->first();

            if (!$currentFeatureTypesValues) {
                $currentFeatureTypesValues = new ProductFeatureTypesValues();
                $currentFeatureTypesValues->fill([
                    'product_id' => $product->id,
                    'product_feature_type_id' => $currentFeatureType->id,
                    'product_feature_value_id' => $currentFeatureValue->id,
                ]);
                $currentFeatureTypesValues->trySaveModel();
            }
        }
    }

    /**
     * @param string $field
     * @param string $lang
     *
     * @return string
     */
    protected function translate(string $field, string $lang = ''): string
    {
        if (empty($lang)) {
            $lang = self::LANG;
        }

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

    protected function truncateTables(): void
    {
        Product::query()->truncate();
        ProductCategory::query()->truncate();
        ProductFamily::query()->truncate();
        ProductFeatureType::query()->truncate();
    }
}
