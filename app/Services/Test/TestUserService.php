<?php

namespace App\Services\Test;

use App\Services\BaseService;
use App\Domain\ServiceContracts\Test\TestUserServiceContract;
use App\Domain\Repositories\Test\TestUserRepositoryContract;

/**
 * Class TestUserService
 * @package App\Services\Test
 */
class TestUserService extends BaseService implements TestUserServiceContract
{
    /**
     * @var TestUserRepositoryContract
     */
    private $repository;

    /**
     * TestUserService constructor.
     * @param TestUserRepositoryContract $repository
     */
    public function __construct(TestUserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return TestUserRepositoryContract
     */
    public function getRepository(): TestUserRepositoryContract
    {
        return $this->repository;
    }
}
