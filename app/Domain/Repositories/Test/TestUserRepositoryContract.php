<?php

namespace App\Domain\Repositories\Test;

use App\Domain\Repositories\MustHaveGetSource;
use App\Models\Test\TestUser;

/**
 * Interface TestUserRepositoryContract
 * @package App\Domain\Repositories\Test
 */
interface TestUserRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return TestUser
     */
    public function store(array $params): TestUser;

    /**
     * @param array $params
     * @return TestUser
     */
    public function getLastByParams(array $params): TestUser;

    /**
     * @param TestUser $testUser
     * @param array $answerIds
     * @return TestUser
     */
    public function storeUserAnswers(TestUser $testUser, array $answerIds): TestUser;

    /**
     * @param TestUser $testUser
     * @param array $params
     * @return bool
     */
    public function update(TestUser $testUser, array $params): bool;
}
