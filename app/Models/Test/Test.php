<?php

namespace App\Models\Test;

use App\Models\BaseModel;
use App\Collections\Test\TestCollection;
use App\Traits\Publishable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * Class Test
 * @package App\Models\Test
 */
class Test extends BaseModel
{
    use Publishable;

    /**
     * @var array
     */
    protected $fillable = ['title', 'image', 'description', 'published'];

    /**
     * @var array
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * @param array $models
     * @return TestCollection
     */
    public function newCollection(array $models = []): TestCollection
    {
        return new TestCollection($models);
    }

    /**
     * @return HasMany
     */
    public function testResults(): HasMany
    {
        return $this->hasMany(TestResult::class)->orderBy('percent_from');
    }

    /**
     * @return HasMany
     */
    public function testQuestions(): HasMany
    {
        return $this->hasMany(TestQuestion::class)->orderBy('id');
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
