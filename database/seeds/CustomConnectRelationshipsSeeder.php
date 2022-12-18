<?php

use Illuminate\Database\Seeder;
use App\Domain\Dictionaries\Users\RolesDictionary;
use Illuminate\Support\Facades\DB;

/**
 * Class CustomConnectRelationshipsSeeder
 */
class CustomConnectRelationshipsSeeder extends Seeder
{
    /**
     * @var array
     */
    private $roles = [
        [
            'slug' => RolesDictionary::ELECTRICIAN,
            'permissionSlugs' => [
                'content.view', 'project.create', 'project.update', 'project.products.add', 'test.pass',
                'product.favorites', 'project.list', 'project.details', 'project.categories.add',
                'project.categories.list', 'project.products.list', 'project.categories.divisions',
                'project.divisions.products', 'project.products.delete', 'project.products.search',
                'project.specifications.show', 'project.delete', 'specification.sections.list',
                'specification.products.list', 'specification.sections.add', 'specification.products.move',
                'specification.products.update', 'specification.products.delete', 'specification.sections.delete',
                'specification.sections.update', 'project.products.update', 'specification.sections.product.add',
                'specification.products.replace', 'project.export', 'specification.files.check', 'specification.files.example',
                'project.create.from.file', 'project.compare', 'project.apply.changes', 'analog.search', 'user.profile.update',
                'user.password.update', 'loyalty.list', 'loyalty.user.register', 'loyalty.register.product.code',
                'loyalty.proposals.list', 'feedback.create', 'user.profile.photo.update', 'user.profile.published.update',
                'user.delete', 'project.categories.delete', 'video.index', 'video.category.list', 'video.search',
                'faq.index', 'news.index', 'news.details', 'test.index', 'test.show', 'test.register', 'product.recommended',
                'product.buywithit', 'user.profile.completeness.check', 'loyalty.receipt.upload'
            ],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table(config('roles.permissionsRoleTable'))->truncate();

        foreach ($this->roles as $role) {
            $this->createPermissions($role);
        }
    }

    /**
     * @param array $role
     */
    private function createPermissions(array $role): void
    {
        $currentRole = config('roles.models.role')::where('slug', '=', $role['slug'])->first();

        if (!$currentRole) {
            return;
        }

        $permissions = config('roles.models.permission')::whereIn('slug', $role['permissionSlugs'])->get()->all();

        foreach ($permissions as $permission) {
            if (empty($currentRole->permissions()->where('slug', '=', $permission->slug)->first())) {
                $currentRole->attachPermission($permission);
            }
        }
    }
}
