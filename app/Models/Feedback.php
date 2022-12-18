<?php

namespace App\Models;

use App\Collections\FeedbackCollection;
use App\Domain\Dictionaries\Feedback\FeedbackStatuses;
use App\Domain\Dictionaries\Feedback\FeedbackTypes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use App\Notifications\HasNotificationTransport;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasCreateLog;

/**
 * Class Feedback
 * @package App\Models
 */
class Feedback extends BaseModel
{
    use Notifiable;
    use HasNotificationTransport;
    use HasCreateLog;

    /**
     * @var array
     */
    protected $fillable = ['email', 'name', 'text', 'user_id', 'status', 'file', 'type'];

    /**
     * @param array $models
     * @return FeedbackCollection
     */
    public function newCollection(array $models = []): FeedbackCollection
    {
        return new FeedbackCollection($models);
    }

    /**
     * @param array $params
     * @return static
     */
    public static function create(array $params): self
    {
        $model = new self($params);
        $model->trySaveModel();

        return $model;
    }

    /**
     * @return string
     */
    public function getStatusOnHumanAttribute(): string
    {
        return FeedbackStatuses::toHuman($this->status);
    }

    /**
     * @return string
     */
    public function getFileUrlAttribute(): string
    {
        if ($this->file === null) {
            return '';
        }

        return Storage::disk('public')->url($this->file);
    }

    /**
     * @return string
     */
    public function getTypeOnHumanAttribute(): string
    {
        return FeedbackTypes::toHuman($this->type);
    }

    /**
     * @param  Builder  $query
     * @param  string  $type
     * @return Builder
     */
    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where([
            'type' => $type,
        ]);
    }
}
