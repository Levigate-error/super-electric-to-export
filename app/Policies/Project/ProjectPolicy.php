<?php

namespace App\Policies\Project;

use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * @var ProjectServiceContract
     */
    private $service;

    /**
     * ProjectPolicy constructor.
     * @param ProjectServiceContract $service
     */
    public function __construct(ProjectServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @param int $projectId
     * @return bool
     */
    public function getOwnerPermission(int $projectId): bool
    {
        return $this->service->getOwnerPermission($projectId);
    }

    /**
     * @param User|null $user
     * @return bool
     */
    private function hasSessionWithoutUser(?User $user): bool
    {
        return empty($user) && !empty(Auth::guard()->getSession());
    }

    /**
     * @param User $user
     * @return bool
     */
    public function list(?User $user): bool
    {
        if ($this->hasSessionWithoutUser($user)) {
            return true;
        }

        return $user->hasPermission('project.list');
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function create(?User $user): bool
    {
        if ($this->hasSessionWithoutUser($user)) {
            return true;
        }

        return $user->hasPermission('project.create');
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function update(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.update') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function delete(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.delete') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function details(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.details') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function products(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.products.list') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function specifications(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.specifications.show') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @return bool
     */
    public function addProduct(?User $user): bool
    {
        if ($this->hasSessionWithoutUser($user)) {
            return true;
        }

        return $user->hasPermission('project.products.add');
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function addCategory(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.categories.add') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function categoriesList(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.categories.list') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function categoryDivisions(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.categories.divisions') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function divisionProducts(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.divisions.products') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function deleteProducts(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.products.delete') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function searchProducts(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.products.search') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function updateProduct(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.products.update') && $hasPermission;
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function export(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.export') && $hasPermission;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function createFromFile(User $user): bool
    {
        return $user->hasPermission('project.create.from.file');
    }

    /**
     * @param User $user
     * @param int $projectId
     * @return bool
     */
    public function compareWithFile(User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        return $user->hasPermission('project.compare') && $hasPermission;
    }

    /**
     * @param User $user
     * @param int $projectId
     * @return bool
     */
    public function applyChanges(User $user, int $projectId): bool
    {
        return $user->hasPermission('project.apply.changes') && $this->getOwnerPermission($projectId);
    }

    /**
     * @param User|null $user
     * @param int $projectId
     * @return bool
     */
    public function deleteCategory(?User $user, int $projectId): bool
    {
        $hasPermission = $this->getOwnerPermission($projectId);

        if (!$user) {
            return $hasPermission;
        }

        return $user->hasPermission('project.categories.delete') && $hasPermission;
    }
}
