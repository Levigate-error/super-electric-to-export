<?php

namespace App\Repositories;

use App\Models\Feedback;
use App\Domain\Repositories\FeedbackRepositoryContract;
use App\Collections\FeedbackCollection;

/**
 * Class FeedbackRepository
 * @package App\Repositories
 */
class FeedbackRepository extends BaseRepository implements FeedbackRepositoryContract
{
    protected $source = Feedback::class;

    /**
     * @param  string  $type
     * @return FeedbackCollection
     */
    public function getByType(string $type): FeedbackCollection
    {
        return $this->getQueryBuilder()
            ->byType($type)
            ->get();
    }
}
