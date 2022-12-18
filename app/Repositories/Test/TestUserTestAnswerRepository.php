<?php

namespace App\Repositories\Test;

use App\Repositories\BaseRepository;
use App\Models\Test\TestUserTestAnswer;
use App\Domain\Repositories\Test\TestUserTestAnswerRepositoryContract;

/**
 * Class TestUserTestAnswerRepository
 * @package App\Repositories\Test
 */
class TestUserTestAnswerRepository extends BaseRepository implements TestUserTestAnswerRepositoryContract
{
    protected $source = TestUserTestAnswer::class;

    /**
     * @param array $params
     * @return TestUserTestAnswer
     */
    public function store(array $params): TestUserTestAnswer
    {
        return $this->getSource()::store($params);
    }
}
