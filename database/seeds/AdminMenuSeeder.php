<?php

use Illuminate\Database\Seeder;
use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Support\Facades\DB;

/**
 * Class AdminMenuSeeder
 */
class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('admin_menu')->truncate();
        DB::table('admin_role_menu')->truncate();

        $administrator = Role::query()->where(['slug' => 'administrator'])->first();

        $this->createDefaultMenu($administrator);
        $this->createCatalogMenu($administrator);
        $this->createLoyaltyProgramMenu($administrator);
        $this->createUsersMenu($administrator);
        $this->createBannersMenu($administrator);
        $this->createVideosMenu($administrator);
        $this->createFaqMenu($administrator);
        $this->createNewsMenu($administrator);
        $this->createFeedbackMenu($administrator);
        $this->createSettingMenu($administrator);
        $this->createTestMenu($administrator);
    }

    /**
     * @param Role $administrator
     */
    private function createTestMenu(Role $administrator): void
    {
        $mainMenu = Menu::create([
            'parent_id' => 0,
            'order'     => 12,
            'title'     => 'Тесты',
            'icon'      => 'fa-align-justify',
            'uri'       => 'test/main',
        ]);
        $mainMenu->roles()->save($administrator);
    }

    /**
     * @param Role $administrator
     */
    private function createSettingMenu(Role $administrator): void
    {
        $mainMenu = Menu::create([
            'parent_id' => 0,
            'order'     => 11,
            'title'     => 'Настройки',
            'icon'      => 'fa-cogs',
            'uri'       => 'setting',
        ]);
        $mainMenu->roles()->save($administrator);
    }

    /**
     * @param Role $administrator
     */
    private function createFeedbackMenu(Role $administrator): void
    {
        $mainMenu = Menu::create([
            'parent_id' => 0,
            'order'     => 10,
            'title'     => 'Обратная связь',
            'icon'      => 'fa-at',
            'uri'       => 'feedback',
        ]);
        $mainMenu->roles()->save($administrator);
    }

    /**
     * @param Role $administrator
     */
    private function createNewsMenu(Role $administrator): void
    {
        $mainMenu = Menu::create([
            'parent_id' => 0,
            'order'     => 9,
            'title'     => 'Новости',
            'icon'      => 'fa-newspaper-o',
            'uri'       => 'news',
        ]);
        $mainMenu->roles()->save($administrator);
    }

    /**
     * @param Role $administrator
     */
    private function createFaqMenu(Role $administrator): void
    {
        $mainMenu = Menu::create([
            'parent_id' => 0,
            'order'     => 8,
            'title'     => 'FAQ',
            'icon'      => 'fa-question',
            'uri'       => 'faq',
        ]);
        $mainMenu->roles()->save($administrator);
    }

    /**
     * @param Role $administrator
     */
    private function createVideosMenu(Role $administrator): void
    {
        $mainMenu = Menu::create([
            'parent_id' => 0,
            'order'     => 7,
            'title'     => 'Видео',
            'icon'      => 'fa-video-camera',
            'uri'       => 'videos',
        ]);
        $mainMenu->roles()->save($administrator);

        $categoryMenu = Menu::create([
            'parent_id' => $mainMenu->id,
            'order'     => 1,
            'title'     => 'Категории',
            'icon'      => 'fa-align-justify',
            'uri'       => 'video/categories',
        ]);
        $categoryMenu->roles()->save($administrator);

        $categoryMenu = Menu::create([
            'parent_id' => $mainMenu->id,
            'order'     => 2,
            'title'     => 'Видео',
            'icon'      => 'fa-align-justify',
            'uri'       => 'video/videos',
        ]);
        $categoryMenu->roles()->save($administrator);
    }

    /**
     * @param Role $administrator
     */
    private function createBannersMenu(Role $administrator): void
    {
        $mainMenu = Menu::create([
            'parent_id' => 0,
            'order'     => 6,
            'title'     => 'Баннеры',
            'icon'      => 'fa-image',
            'uri'       => 'banners',
        ]);
        $mainMenu->roles()->save($administrator);
    }

    /**
     * @param Role $administrator
     */
    private function createUsersMenu(Role $administrator): void
    {
        $mainMenu = Menu::create([
            'parent_id' => 0,
            'order'     => 5,
            'title'     => 'Пользователи',
            'icon'      => 'fa-users',
            'uri'       => 'users',
        ]);
        $mainMenu->roles()->save($administrator);

        
    }

    /**
     * @param Role $administrator
     */
    private function createLoyaltyProgramMenu(Role $administrator): void
    {
        $mainMenu = Menu::create([
            'parent_id' => 0,
            'order'     => 4,
            'title'     => 'Программа лояльности',
            'icon'      => 'fa-dollar',
            'uri'       => 'loyalty-program/loyalties',
        ]);
        $mainMenu->roles()->save($administrator);

        $loyaltyMenu = Menu::create([
            'parent_id' => $mainMenu->id,
            'order'     => 1,
            'title'     => 'Акции',
            'icon'      => 'fa-align-justify',
            'uri'       => 'loyalty-program/loyalties',
        ]);
        $loyaltyMenu->roles()->save($administrator);

        $loyaltyMenu = Menu::create([
            'parent_id' => $mainMenu->id,
            'order'     => 1,
            'title'     => 'Чеки',
            'icon'      => 'fa-check',
            'uri'       => 'loyalty-program/receipts',
        ]);
        $loyaltyMenu->roles()->save($administrator);

        $settingMenu = Menu::create([
            'parent_id' => $mainMenu->id,
            'order'     => 2,
            'title'     => 'Настройки',
            'icon'      => 'fa-gears',
            'uri'       => 'loyalty-program/settings/certificates',
        ]);
        $settingMenu->roles()->save($administrator);

        $productsCodeMenu = Menu::create([
            'parent_id' => $settingMenu->id,
            'order'     => 2,
            'title'     => 'Коды продуктов',
            'icon'      => 'fa-gears',
            'uri'       => 'loyalty-program/settings/product-codes',
        ]);
        $productsCodeMenu->roles()->save($administrator);

        $certificateMenu = Menu::create([
            'parent_id' => $settingMenu->id,
            'order'     => 1,
            'title'     => 'Сертификаты',
            'icon'      => 'fa-gears',
            'uri'       => 'loyalty-program/settings/certificates',
        ]);
        $certificateMenu->roles()->save($administrator);
    }

    /**
     * @param Role $administrator
     */
    private function createCatalogMenu(Role $administrator): void
    {
        $catalogMenu = Menu::create([
            'parent_id' => 0,
            'order'     => 3,
            'title'     => 'Каталог',
            'icon'      => 'fa-th-list',
            'uri'       => '',
        ]);
        $catalogMenu->roles()->save($administrator);

        $productCategoryMenu = Menu::create([
            'parent_id' => $catalogMenu->id,
            'order'     => 1,
            'title'     => 'Товарные группы',
            'icon'      => 'fa-align-justify',
            'uri'       => 'catalog/product-categories',
        ]);
        $productCategoryMenu->roles()->save($administrator);

        $productDivisionMenu = Menu::create([
            'parent_id' => $catalogMenu->id,
            'order'     => 2,
            'title'     => 'Признаки изделий',
            'icon'      => 'fa-align-justify',
            'uri'       => 'catalog/product-divisions',
        ]);
        $productDivisionMenu->roles()->save($administrator);

        $productFamilyMenu = Menu::create([
            'parent_id' => $catalogMenu->id,
            'order'     => 3,
            'title'     => 'Серии',
            'icon'      => 'fa-align-justify',
            'uri'       => 'catalog/product-families',
        ]);
        $productFamilyMenu->roles()->save($administrator);

        $productMenu = Menu::create([
            'parent_id' => $catalogMenu->id,
            'order'     => 4,
            'title'     => 'Товары',
            'icon'      => 'fa-product-hunt',
            'uri'       => 'catalog/products',
        ]);
        $productMenu->roles()->save($administrator);
    }

    /**
     * @param Role $administrator
     */
    private function createDefaultMenu(Role $administrator): void
    {
        // add default menus.
        Menu::truncate();
        Menu::insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => 'Dashboard',
                'icon'      => 'fa-bar-chart',
                'uri'       => '/',
            ],
            [
                'parent_id' => 0,
                'order'     => 2,
                'title'     => 'Admin',
                'icon'      => 'fa-tasks',
                'uri'       => '',
            ],
            [
                'parent_id' => 2,
                'order'     => 3,
                'title'     => 'Users',
                'icon'      => 'fa-users',
                'uri'       => 'auth/users',
            ],
            [
                'parent_id' => 2,
                'order'     => 4,
                'title'     => 'Roles',
                'icon'      => 'fa-user',
                'uri'       => 'auth/roles',
            ],
            [
                'parent_id' => 2,
                'order'     => 5,
                'title'     => 'Permission',
                'icon'      => 'fa-ban',
                'uri'       => 'auth/permissions',
            ],
            [
                'parent_id' => 2,
                'order'     => 6,
                'title'     => 'Menu',
                'icon'      => 'fa-bars',
                'uri'       => 'auth/menu',
            ],
            [
                'parent_id' => 2,
                'order'     => 7,
                'title'     => 'Operation log',
                'icon'      => 'fa-history',
                'uri'       => 'auth/logs',
            ],
        ]);

        // add role to menu.
        Menu::find(2)->roles()->save($administrator);
    }
}
