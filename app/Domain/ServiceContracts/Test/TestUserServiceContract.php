<?php

namespace App\Domain\ServiceContracts\Test;

use App\Domain\Repositories\Test\TestUserRepositoryContract;

/**
 * Interface TestUserServiceContract
 * @package App\Domain\ServiceContracts\Test
 */
interface TestUserServiceContract
{
    /**
     * @return TestUserRepositoryContract
     */
    public function getRepository(): TestUserRepositoryContract;
}
