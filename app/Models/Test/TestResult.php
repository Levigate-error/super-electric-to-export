<?php

namespace App\Models\Test;

use App\Models\BaseModel;
use App\Collections\Test\TestResultCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasImageAttribute;

/**
 * Class TestResult
 * @package App\Models\Test
 */
class TestResult extends BaseModel
{
    use HasImageAttribute;

    /**
     * @var array
     */
    protected $fillable = ['test_id', 'title', 'description', 'from', 'to', 'points'];

    /**
     * @param array $models
     * @return TestResultCollection
     */
    public function newCollection(array $models = []): TestResultCollection
    {
        return new TestResultCollection($models);
    }

    /**
     * @return BelongsTo
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
