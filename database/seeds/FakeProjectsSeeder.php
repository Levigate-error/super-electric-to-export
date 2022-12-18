<?php

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\ServiceContracts\Project\ProjectStatusServiceContract;
use App\Domain\ServiceContracts\Project\ProjectAttributeServiceContract;
use App\Domain\ServiceContracts\ProductServiceContract;
use App\Domain\ServiceContracts\Project\ProjectSpecificationServiceContract;

/**
 * Class FakeProjectsSeeder
 */
class FakeProjectsSeeder extends Seeder
{
    /**
     * @var int
     */
    private $length = 20;

    /**
     * @var Generator
     */
    private $fakerGenerator;

    /**
     * @var ProjectServiceContract
     */
    private $projectService;

    /**
     * @var ProjectStatusServiceContract
     */
    private $projectStatusService;

    /**
     * @var ProjectAttributeServiceContract
     */
    private $projectAttributeService;

    /**
     * @var ProductServiceContract
     */
    private $productService;

    /**
     * @var ProjectSpecificationServiceContract
     */
    private $projectSpecificationService;

    public function __construct(
        ProjectServiceContract $projectService,
        ProjectStatusServiceContract $projectStatusService,
        ProjectAttributeServiceContract $projectAttributeService,
        ProductServiceContract $productService,
        ProjectSpecificationServiceContract $projectSpecificationService
    )
    {
        $this->fakerGenerator = Factory::create('ru_RU');

        $this->projectService = $projectService;
        $this->projectStatusService = $projectStatusService;
        $this->projectAttributeService = $projectAttributeService;
        $this->productService = $productService;
        $this->projectSpecificationService = $projectSpecificationService;
    }

    public function run()
    {
        DB::table('projects')->truncate();

        $this->command->line('<comment>Generate projects </comment>');
        $progressBar = new ProgressBar($this->command->getOutput());
        $progressBar->start($this->length);

        for ($i = 0; $i < $this->length; $i++) {
            $project = $this->generateProject();
            $this->addProducts($project);

            $specification = $this->generateSpecification($project);
            $this->generateSpecificationSections($specification);

            $this->productMix($project, $specification);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->line('');
    }

    /**
     * @param array $project
     * @param array $specification
     * @return bool
     */
    private function productMix(array $project, array $specification): bool
    {
        $sections = $this->projectSpecificationService->getSpecificationSectionsList($specification['id']);
        $products = $this->projectService->getNotUsedProducts($project['id']);

        foreach ($sections as $section) {
            foreach ($products as $product) {
                $amount = $this->fakerGenerator->numberBetween(1, $product->pivot->not_used_amount);

                $productMixParams = [
                    'product' => $product->id,
                    'section' => $section['id'],
                    'amount' => $amount,
                ];

                $this->projectSpecificationService->moveProduct($specification['id'], $productMixParams);
            }
        }

        return true;
    }

    /**
     * @param array $specification
     * @param int|null $count
     * @return bool
     */
    private function generateSpecificationSections(array $specification, int $count = null): bool
    {
        $sections = $this->getSections($count);

        foreach ($sections as $section) {
            $this->projectSpecificationService->addSpecificationSection($specification['id'], $section);
        }

        return true;
    }

    /**
     * @param int|null $count
     * @return array
     */
    private function getSections(int $count = null): array
    {
        $count = $count ?? $this->fakerGenerator->numberBetween(1, 9);
        $sections = [];

        for ($i = 0; $i < $count; $i++) {
            $sections[] = [
                'title' => $this->fakerGenerator->word,
            ];
        }

        return $sections;
    }

    /**
     * @param array $project
     * @return array
     */
    private function generateSpecification(array $project): array
    {
        $specifications = $this->projectService->getProjectSpecifications($project['id']);

        if (empty($specifications)) {
            $specifications = $this->projectService->createProjectSpecification($project['id']);
        }

        return $specifications;
    }

    /**
     * @param array $project
     * @return bool
     */
    private function addProducts(array $project): bool
    {
        $products = $this->getProducts();

        foreach ($products as $product) {
            $productData = [
                'product' => $product['id'],
                'projects' => [
                    [
                        'project' => $project['id'],
                        'amount' => $this->fakerGenerator->numberBetween(1, 9),
                    ],
                ],
            ];

            $this->projectService->addProductToProjects($productData);
        }

        return true;
    }

    /**
     * @param int|null $count
     * @param int|null $page
     * @return array
     */
    private function getProducts(int $count = null, int $page = null): array
    {
        $count = $count ?? $this->fakerGenerator->numberBetween(1, 9);
        $page = $page ?? $this->fakerGenerator->numberBetween(1, 270);

        $products = $this->productService->getProductsByParams([
            'limit' => $count,
            'page' => $page,
        ]);

        return $products['products']->resolve();
    }

    /**
     * @return array
     */
    private function generateProject(): array
    {
        $projectData = [
            'title' => $this->fakerGenerator->word,
            'address' => $this->fakerGenerator->address,
            'project_status_id' => $this->getProjectStatus()['id'],
            'user_id' => $this->getProjectUser()['id'],
        ];

        $project = $this->projectService->store($projectData);
        $this->projectService->updateProjectContacts($project['id'], $this->generateProjectContacts());
        $this->projectService->updateProjectAttributes($project['id'], $this->generateProjectAttributes());

        return $project;
    }

    /**
     * @return array
     */
    private function getProjectStatus(): array
    {
        $statuses = $this->projectStatusService->getStatusesList();

        return Arr::random($statuses);
    }

    /**
     * @return array
     */
    private function getProjectUser(): array
    {
        $users = User::query()->whereHas('roles', static function (Builder $builder) {
            $builder->where([
                'slug' => 'electrician'
            ]);
            return $builder;
        })->get()->toArray();

        return Arr::random($users);
    }

    /**
     * @param int|null $count
     * @return array
     */
    private function generateProjectContacts(int $count = null): array
    {
        $count = $count ?? $this->fakerGenerator->numberBetween(1, 9);
        $contacts = [];

        for ($i = 0; $i < $count; $i++) {
            $contacts[] = [
                'name' => $this->fakerGenerator->firstName,
                'phone' => $this->fakerGenerator->phoneNumber,
            ];
        }

        return $contacts;
    }

    /**
     * @return array
     */
    private function generateProjectAttributes(): array
    {
        $attributes = $this->projectAttributeService->getAttributesList();
        $values = [];

        foreach ($attributes as $attribute) {
            $value = Arr::random($attribute['values']);

            $values[] = $value['id'];
        }

        return $values;
    }
}
