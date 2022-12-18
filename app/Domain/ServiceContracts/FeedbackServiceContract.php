<?php

namespace App\Domain\ServiceContracts;

use App\Domain\Repositories\FeedbackRepositoryContract;
use App\Http\Resources\FeedbackResource;

/**
 * Interface FeedbackServiceContract
 * @package App\Domain\ServiceContracts
 */
interface FeedbackServiceContract
{
    /**
     * @return FeedbackRepositoryContract
     */
    public function getRepository(): FeedbackRepositoryContract;

    /**
     * @param array $params
     * @return array
     */
    public function createFeedback(array $params): array;

    /**
     * @return bool
     */
    public function isRecaptchaRequired(): bool;
}
