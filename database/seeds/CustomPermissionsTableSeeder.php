<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomPermissionsTableSeeder
 */
class CustomPermissionsTableSeeder extends Seeder
{
    /**
     * @var array
     */
    private $resource = [
        [
            'name'        => 'Can View Content',
            'slug'        => 'content.view',
            'description' => 'Can view Content',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can Create Projects',
            'slug'        => 'project.create',
            'description' => 'Can create new projects',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can See Projects list',
            'slug'        => 'project.list',
            'description' => 'Can see projects list',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can Save Projects',
            'slug'        => 'project.update',
            'description' => 'Can save projects',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can delete Projects',
            'slug'        => 'project.delete',
            'description' => 'Can delete projects',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can Show Project',
            'slug'        => 'project.details',
            'description' => 'Can show project',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can Add Products To Projects',
            'slug'        => 'project.products.add',
            'description' => 'Can Add Products To Projects',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can delete Product from Project',
            'slug'        => 'project.products.delete',
            'description' => 'Can delete Product from Project',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get project products list',
            'slug'        => 'project.products.list',
            'description' => 'Can get project products list',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can search project products',
            'slug'        => 'project.products.search',
            'description' => 'Can search project products',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can Add Categories To Projects',
            'slug'        => 'project.categories.add',
            'description' => 'Can Add Categories To Projects',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get project categories list',
            'slug'        => 'project.categories.list',
            'description' => 'Can get project categories list',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get project and category divisions',
            'slug'        => 'project.categories.divisions',
            'description' => 'Can get project and category divisions',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get project and division products',
            'slug'        => 'project.divisions.products',
            'description' => 'Can get project and division products',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can see project specifications',
            'slug'        => 'project.specifications.show',
            'description' => 'Can see project specifications',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can Change Product Price In The Specification',
            'slug'        => 'specification.products.change.price',
            'description' => 'Can Change Product Price In The Specification',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get specification sections list',
            'slug'        => 'specification.sections.list',
            'description' => 'Can get specification categories list',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can add specification section',
            'slug'        => 'specification.sections.add',
            'description' => 'Can add specification section',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can Pass Tests',
            'slug'        => 'test.pass',
            'description' => 'Can Pass Tests',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can Register',
            'slug'        => 'register',
            'description' => 'Can Register',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can work with favorites products',
            'slug'        => 'product.favorites',
            'description' => 'Can work with favorites products',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can move specification products',
            'slug'        => 'specification.products.move',
            'description' => 'Can move specification products',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can update specification products',
            'slug'        => 'specification.products.update',
            'description' => 'Can update specification products',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can delete specification products',
            'slug'        => 'specification.products.delete',
            'description' => 'Can delete specification products',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can delete specification section',
            'slug'        => 'specification.sections.delete',
            'description' => 'Can delete specification section',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can update specification section',
            'slug'        => 'specification.sections.update',
            'description' => 'Can update specification section',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can update project product',
            'slug'        => 'project.products.update',
            'description' => 'Can update project product',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can add product to specification section',
            'slug'        => 'specification.sections.product.add',
            'description' => 'Can add product to specification section',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can replace specification products',
            'slug'        => 'specification.products.replace',
            'description' => 'Can replace specification products',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can export project',
            'slug'        => 'project.export',
            'description' => 'Can export project',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can check specification files',
            'slug'        => 'specification.files.check',
            'description' => 'Can check specification files',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get specification file example',
            'slug'        => 'specification.files.example',
            'description' => 'Can get specification file example',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can create project from file',
            'slug'        => 'project.create.from.file',
            'description' => 'Can create project from file',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can compare file with project',
            'slug'        => 'project.compare',
            'description' => 'Can compare file with project',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can apply changes from file to project',
            'slug'        => 'project.apply.changes',
            'description' => 'Can apply changes from file to project',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can search analogue',
            'slug'        => 'analog.search',
            'description' => 'Can search analogue',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can update profile',
            'slug'        => 'user.profile.update',
            'description' => 'Can update profile',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can update password',
            'slug'        => 'user.password.update',
            'description' => 'Can update password',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get loyalty list',
            'slug'        => 'loyalty.list',
            'description' => 'Can get loyalty list',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can register user in loyalty',
            'slug'        => 'loyalty.user.register',
            'description' => 'Can register user in loyalty',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can register product code',
            'slug'        => 'loyalty.register.product.code',
            'description' => 'Can register product code',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get proposals list',
            'slug'        => 'loyalty.proposals.list',
            'description' => 'Can get proposals list',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can add feedback',
            'slug'        => 'feedback.create',
            'description' => 'Can add feedback',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can update user photo',
            'slug'        => 'user.profile.photo.update',
            'description' => 'Can update user photo',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can update user published',
            'slug'        => 'user.profile.published.update',
            'description' => 'Can update user published',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can delete user',
            'slug'        => 'user.delete',
            'description' => 'Can delete user',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can delete project category',
            'slug'        => 'project.categories.delete',
            'description' => 'Can delete project category',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can view video page',
            'slug'        => 'video.index',
            'description' => 'Can view video page',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get video category list',
            'slug'        => 'video.category.list',
            'description' => 'Can get video category list',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can search video',
            'slug'        => 'video.search',
            'description' => 'Can search video',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can view faq page',
            'slug'        => 'faq.index',
            'description' => 'Can view faq page',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can view news page',
            'slug'        => 'news.index',
            'description' => 'Can view news page',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can view news details',
            'slug'        => 'news.details',
            'description' => 'Can view news details',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can view tests page',
            'slug'        => 'test.index',
            'description' => 'Can view tests page',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can view test details',
            'slug'        => 'test.show',
            'description' => 'Can view test details',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can register test',
            'slug'        => 'test.register',
            'description' => 'Can register test',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get recommended products',
            'slug'        => 'product.recommended',
            'description' => 'Can get recommended products',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can get buy with it products',
            'slug'        => 'product.buywithit',
            'description' => 'Can get buy with it products',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can check profile completeness',
            'slug'        => 'user.profile.completeness.check',
            'description' => 'Can check profile completeness',
            'model'       => 'Permission',
        ],
        [
            'name'        => 'Can upload receipts',
            'slug'        => 'loyalty.receipt.upload',
            'description' => 'Can upload receipts',
            'model'       => 'Permission',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('roles.permissionsTable'))->truncate();

        foreach ($this->resource as $permissionItem) {

            $newPermissionItem = config('roles.models.permission')::where('slug', '=', $permissionItem['slug'])->first();

            if ($newPermissionItem === null) {
                config('roles.models.permission')::create([
                    'name'          => $permissionItem['name'],
                    'slug'          => $permissionItem['slug'],
                    'description'   => $permissionItem['description'],
                    'model'         => $permissionItem['model'],
                ]);
            }
        }
    }
}
