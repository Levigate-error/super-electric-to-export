<?php

namespace App\Models;

use App\Collections\User\UserActivityCollection;

/**
 * Class UserActivity
 * @package App\Models
 */
class UserActivity extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'source_id', 'source_type'];

    /**
     * @param array $models
     * @return UserActivityCollection
     */
    public function newCollection(array $models = []): UserActivityCollection
    {
        return new UserActivityCollection($models);
    }

    /**
     * @return string
     */
    public function getTitleAttribute(): string
    {
        if ($this->isQueryModel($this->source_type) === false) {
            return '';
        }

        try {
            $sourceDetails = $this->source_type::query()->findOrFail($this->source_id);
        } catch (\Throwable $e) {
            return '';
        }

        if (isset($sourceDetails->title) === true) {
            return $sourceDetails->title;
        }

        return '';
    }

    /**
     * Модель ли это
     *
     * @param string $type
     * @return bool
     */
    private function isQueryModel(string $type): bool
    {
        return class_exists($type) && method_exists($type, 'query');
    }
}
