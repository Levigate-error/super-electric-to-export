<?php

namespace App\Models\Test;

use App\Models\BaseModel;
use App\Collections\Test\TestQuestionCollection;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * Class TestQuestion
 * @package App\Models\Test
 */
class TestQuestion extends BaseModel
{
    use Publishable;

    /**
     * @var array
     */
    protected $fillable = ['test_id', 'question', 'image', 'video', 'published'];

    /**
     * @var array
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * @param array $models
     * @return TestQuestionCollection
     */
    public function newCollection(array $models = []): TestQuestionCollection
    {
        return new TestQuestionCollection($models);
    }

    /**
     * @return BelongsTo
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    /**
     * @return HasMany
     */
    public function testAnswers(): HasMany
    {
        return $this->hasMany(TestAnswer::class)->orderBy('id');
    }

    /**
     * @return string
     */
    public function getImagePathAttribute(): string
    {
        if ($this->image === null) {
            return '';
        }

        return Storage::disk('public')->url($this->image);
    }
}
