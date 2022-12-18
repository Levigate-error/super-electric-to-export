<?php

namespace App\Utils\ProductChangers\Resolvers\Drivers;

use App\Domain\UtilContracts\ProductChangers\Resolvers\Contracts\ProjectProductChangesDriverContract;
use App\Models\Project\ProjectProductChange;
use App\Domain\ServiceContracts\ProductServiceContract;
use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Traits\ServiceGetter;
use Illuminate\Support\Facades\DB;

class AddedDriver implements ProjectProductChangesDriverContract
{
    use ServiceGetter;

    /**
     * @param ProjectProductChange $projectProductChange
     * @return bool
     * @throws BindingResolutionException
     */
    public function resolve(ProjectProductChange $projectProductChange): bool
    {
        if ($projectProductChange->used) {
            return false;
        }

        $productService = $this->getService(ProductServiceContract::class);
        $projectService = $this->getService(ProjectServiceContract::class);

        $product = $productService->getProductByParam(['vendor_code' => $projectProductChange->vendor_code]);

        if (!$product) {
            return false;
        }

        DB::beginTransaction();

        $paramsToAddProduct = $projectService->prepareProductDataToAdd($projectProductChange->project_id, $product->id, 1);
        $projectService->addProductToProjects($paramsToAddProduct);

        $additionalParams = json_decode($projectProductChange->additional_params);
        $productParams = [
            'in_stock' => $additionalParams->in_stock === __('project.file.boolean_check_word'),
            'discount' =>  (int) $additionalParams->discount,
            'amount' => (int) $additionalParams->amount,
            'real_price' => (float) $additionalParams->real_price,
        ];

        $projectService->updateProjectProduct($projectProductChange->project_id, $product->id, $productParams);

        $projectProductChange->setUsed();

        DB::commit();

        return true;
    }
}
