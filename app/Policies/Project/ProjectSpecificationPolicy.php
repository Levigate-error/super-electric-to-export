<?php

namespace App\Policies\Project;

use App\Domain\ServiceContracts\Project\ProjectSpecificationServiceContract;
use App\Domain\Repositories\Project\ProjectSpecificationRepository;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ProjectSpecificationPolicy
 * @package App\Policies
 */
class ProjectSpecificationPolicy
{
    use HandlesAuthorization;

    /**
     * @var ProjectSpecificationServiceContract
     */
    private $service;

    /**
     * @var ProjectSpecificationRepository
     */
    private $repository;

    /**
     * ProjectSpecificationPolicy constructor.
     * @param ProjectSpecificationServiceContract $service
     */
    public function __construct(ProjectSpecificationServiceContract $service)
    {
        $this->service = $service;
        $this->repository = $service->getRepository();
    }

    /**
     * @param int $specificationId
     * @return bool
     */
    public function getOwnerPermission(int $specificationId): bool
    {
        $source = $this->repository->getSource();
        $specification = $source::query()->findOrFail($specificationId);

        if(empty($project = $specification->project)) {
            return false;
        }

        return $project->checkOwnerPermission();
    }

    /**
     * @param User|null $user
     * @param int $specificationId
     * @return bool
     */
    public function specificationSectionsList(?User $user, int $specificationId): bool
    {
        $hasPermission = $this->getOwnerPermission($specificationId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('specification.sections.list') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $specificationId
     * @return bool
     */
    public function specificationSectionsAdd(?User $user, int $specificationId): bool
    {
        $hasPermission = $this->getOwnerPermission($specificationId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('specification.sections.add') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $specificationId
     * @return bool
     */
    public function specificationProductsMove(?User $user, int $specificationId): bool
    {
        $hasPermission = $this->getOwnerPermission($specificationId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('specification.products.move') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $specificationId
     * @return bool
     */
    public function specificationProductsUpdate(?User $user, int $specificationId): bool
    {
        $hasPermission = $this->getOwnerPermission($specificationId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('specification.products.update') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $specificationId
     * @return bool
     */
    public function specificationProductsDelete(?User $user, int $specificationId): bool
    {
        $hasPermission = $this->getOwnerPermission($specificationId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('specification.products.delete') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $specificationId
     * @return bool
     */
    public function specificationSectionsDelete(?User $user, int $specificationId): bool
    {
        $hasPermission = $this->getOwnerPermission($specificationId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('specification.sections.delete') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $specificationId
     * @return bool
     */
    public function specificationSectionsUpdate(?User $user, int $specificationId): bool
    {
        $hasPermission = $this->getOwnerPermission($specificationId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('specification.sections.update') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $specificationId
     * @return bool
     */
    public function specificationProductsReplace(?User $user, int $specificationId): bool
    {
        $hasPermission = $this->getOwnerPermission($specificationId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('specification.products.replace') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $specificationId
     * @return bool
     */
    public function specificationSectionsProductAdd(?User $user, int $specificationId): bool
    {
        $hasPermission = $this->getOwnerPermission($specificationId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('specification.sections.product.add') && $hasPermission;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function fileCheck(User $user): bool
    {
        return $user->hasPermission('specification.files.check');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function fileExample(User $user): bool
    {
        return $user->hasPermission('specification.files.example');
    }
}
