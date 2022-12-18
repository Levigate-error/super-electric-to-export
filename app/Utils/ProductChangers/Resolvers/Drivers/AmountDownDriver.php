<?php

namespace App\Utils\ProductChangers\Resolvers\Drivers;

use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Domain\ServiceContracts\Project\ProjectSpecificationProductServiceContract;
use App\Domain\ServiceContracts\Project\ProjectSpecificationServiceContract;
use App\Domain\UtilContracts\ProductChangers\Resolvers\Contracts\ProjectProductChangesDriverContract;
use App\Models\Project\ProjectProductChange;
use App\Traits\ServiceGetter;
use Illuminate\Support\Facades\DB;

class AmountDownDriver implements ProjectProductChangesDriverContract
{
    use ServiceGetter;

    /**
     * @param ProjectProductChange $projectProductChange
     * @return bool
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function resolve(ProjectProductChange $projectProductChange): bool
    {
        if ($projectProductChange->used) {
            return false;
        }

        $projectService = $this->getService(ProjectServiceContract::class);
        $specificationProductService = $this->getService(ProjectSpecificationProductServiceContract::class);
        $specificationService = $this->getService(ProjectSpecificationServiceContract::class);

        $specification = $projectService->getProjectSpecifications($projectProductChange->project_id);
        $projectProduct = $projectService->getProjectProduct($projectProductChange->project_id, $projectProductChange->product_id);
        $specificationProducts = $specificationProductService->getSpecificationProductsByProduct($specification['id'], $projectProductChange->product_id);

        /**
         * Поулчаем кол-ство товара используемеого в спецификации.
         * Если это значение меньше, чем новое значение, то уменьшаем кол-ство, которое используется в спеке.
         * Тут порядок не важен, просто по порядку, пока кол-ство товара в спеке на станет равно новому кол-ству товара.
         */
        $minAmount = $projectProduct->pivot->amount - $projectProduct->pivot->not_used_amount;

        $projectProductChange->new_value = 1;

        DB::beginTransaction();

        if ($projectProductChange->new_value < $minAmount) {
            $amountDiff = $projectProduct->pivot->amount - $projectProductChange->new_value;

            foreach ($specificationProducts as $specificationProduct) {
                if ($amountDiff === 0) {
                    break;
                }

                if ($amountDiff >= $specificationProduct->amount) {
                    $specificationService->deleteProduct($specificationProduct->id);

                    $amountDiff -= $specificationProduct->amount;
                } else {
                    $params = [
                        'amount' => $specificationProduct->amount - $amountDiff,
                    ];

                    $specificationService->updateProduct($specification['id'], $specificationProduct->id, $params);
                    $amountDiff = 0;
                }
            }
        }

        $productParams = [
            'amount' => $projectProductChange->new_value,
        ];
        $projectService->updateProjectProduct($projectProductChange->project_id, $projectProductChange->product_id, $productParams);

        $projectProductChange->setUsed();

        DB::commit();

        return true;
    }
}
