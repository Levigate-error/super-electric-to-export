<?php

namespace App\Domain\ServiceContracts\Video;

use App\Domain\Repositories\Video\VideoRepositoryContract;

/**
 * Interface VideoServiceContract
 * @package App\Domain\ServiceContracts\Video
 */
interface VideoServiceContract
{
    /**
     * @return VideoRepositoryContract
     */
    public function getRepository(): VideoRepositoryContract;

    /**
     * @param array $params
     * @return array
     */
    public function getVideosByParams(array $params = []): array;
}
