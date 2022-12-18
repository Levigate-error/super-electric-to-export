<?php

namespace App\Models\Test;

use App\Models\BaseModel;
use App\Collections\Test\TestUserTestAnswerCollection;

/**
 * Class TestUserTestAnswer
 * @package App\Models\Test
 */
class TestUserTestAnswer extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['test_user_id', 'test_answer_id'];

    /**
     * @var string
     */
    protected $table = 'tests_users_test_answers';

    /**
     * @param array $models
     * @return TestUserTestAnswerCollection
     */
    public function newCollection(array $models = []): TestUserTestAnswerCollection
    {
        return new TestUserTestAnswerCollection($models);
    }
}
