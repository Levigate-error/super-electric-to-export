<?php

namespace App\Repositories\Test;

use App\Repositories\BaseRepository;
use App\Models\Test\TestUser;
use App\Domain\Repositories\Test\TestUserRepositoryContract;

/**
 * Class TestUserRepository
 * @package App\Repositories\Test
 */
class TestUserRepository extends BaseRepository implements TestUserRepositoryContract
{
    protected $source = TestUser::class;

    /**
     * @param array $params
     * @return TestUser
     */
    public function store(array $params): TestUser
    {
        return $this->getSource()::store($params);
    }

    /**
     * @param array $params
     * @return TestUser
     */
    public function getLastByParams(array $params): TestUser
    {
        return $this
            ->getQueryBuilder()
            ->where($params)
            ->latest()
            ->first();
    }

    /**
     * @param TestUser $testUser
     * @param array $answerIds
     * @return TestUser
     */
    public function storeUserAnswers(TestUser $testUser, array $answerIds): TestUser
    {
        $testUser
            ->userTestAnswers()
            ->attach($answerIds);

        return $testUser->refresh();
    }

    /**
     * @param TestUser $testUser
     * @param array $params
     * @return bool
     */
    public function update(TestUser $testUser, array $params): bool
    {
        return $testUser->fill($params)->trySaveModel();
    }
}
