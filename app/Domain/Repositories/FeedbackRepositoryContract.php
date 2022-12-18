<?php

namespace App\Domain\Repositories;

use App\Collections\FeedbackCollection;

/**
 * Interface FeedbackRepositoryContract
 * @package App\Domain\Repositories
 */
interface FeedbackRepositoryContract extends MustHaveGetSource
{
    /**
     * @param  string  $type
     * @return FeedbackCollection
     */
    public function getByType(string $type): FeedbackCollection;
}
