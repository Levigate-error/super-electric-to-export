<?php

namespace App\Models\Test;

use App\Models\BaseModel;
use App\Collections\Test\TestUserCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class TestUser
 * @package App\Models\Test
 */
class TestUser extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['test_id', 'user_id', 'test_result_id', 'points', 'max_points'];

    /**
     * @var string
     */
    protected $table = 'tests_users';

    /**
     * @param array $models
     * @return TestUserCollection
     */
    public function newCollection(array $models = []): TestUserCollection
    {
        return new TestUserCollection($models);
    }

    /**
     * @return HasMany
     */
    public function testUserTestAnswers(): HasMany
    {
        return $this->hasMany(TestUserTestAnswer::class)->orderBy('id');
    }

    /**
     * @return BelongsToMany
     */
    public function userTestAnswers(): BelongsToMany
    {
        return $this->belongsToMany(TestAnswer::class, 'tests_users_test_answers')->withTimestamps();
    }

    /**
     * @return BelongsTo
     */
    public function testResult(): BelongsTo
    {
        return $this->belongsTo(TestResult::class);
    }
}
