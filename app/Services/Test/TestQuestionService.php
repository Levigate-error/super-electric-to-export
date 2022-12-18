<?php

namespace App\Services\Test;

use App\Services\BaseService;
use App\Domain\ServiceContracts\Test\TestQuestionServiceContract;
use App\Domain\Repositories\Test\TestQuestionRepositoryContract;

/**
 * Class TestQuestionService
 * @package App\Services\Test
 */
class TestQuestionService extends BaseService implements TestQuestionServiceContract
{
    /**
     * @var TestQuestionRepositoryContract
     */
    private $repository;

    /**
     * TestQuestionService constructor.
     * @param TestQuestionRepositoryContract $repository
     */
    public function __construct(TestQuestionRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return TestQuestionRepositoryContract
     */
    public function getRepository(): TestQuestionRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @return array
     */
    public function getTestQuestionsForSelect(): array
    {
        return $this->repository
            ->getByParams()
            ->untype()
            ->mapWithKeys(static function ($item) {
                return [
                    $item['id'] => substr($item['question'], 0, 140),
                ];
            })
            ->toArray();
    }
}
