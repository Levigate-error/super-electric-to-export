<?php

namespace App\Models\Test;

use App\Models\BaseModel;
use App\Collections\Test\TestAnswerCollection;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TestAnswer
 * @package App\Models\Test
 */
class TestAnswer extends BaseModel
{
    use Publishable;

    /**
     * @var array
     */
    protected $fillable = ['test_question_id', 'answer', 'is_correct', 'description', 'points', 'published'];

    /**
     * @var array
     */
    protected $casts = [
        'is_correct' => 'boolean',
        'published' => 'boolean',
        'test_question_id' => 'int',
        'points' => 'int',
    ];

    /**
     * @param array $models
     * @return TestAnswerCollection
     */
    public function newCollection(array $models = []): TestAnswerCollection
    {
        return new TestAnswerCollection($models);
    }

    /**
     * @return BelongsTo
     */
    public function testQuestion(): BelongsTo
    {
        return $this->belongsTo(TestQuestion::class);
    }
}
