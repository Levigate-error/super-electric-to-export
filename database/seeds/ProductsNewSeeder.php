<?php

use Database\Seeds\Helpers\CatalogNewResources;


/**
 * Class ProductsSeeder
 */
class ProductsNewSeeder extends ProductsSeeder
{
    protected const LANG = 'ru';
    protected const CATEGORIES_IN_MAIN = 2;

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $resourcesHelper = new CatalogNewResources();

        $products = $resourcesHelper->getProductsFromFiles($this->command, self::LANG);

        $categories = $this->updateCategories($products);
        $divisions = $this->updateDivisions($products);
        $families = $this->updateFamilies($products);

        $this->updateProducts($products, $divisions, $categories, $families);

        $this->command->line('');
    }
}
