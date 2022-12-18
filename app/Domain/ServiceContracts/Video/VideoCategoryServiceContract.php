<?php

namespace App\Domain\ServiceContracts\Video;

use App\Domain\Repositories\Video\VideoCategoryRepositoryContract;

/**
 * Interface VideoCategoryServiceContract
 * @package App\Domain\ServiceContracts\Video
 */
interface VideoCategoryServiceContract
{
    /**
     * @return VideoCategoryRepositoryContract
     */
    public function getRepository(): VideoCategoryRepositoryContract;

    /**
     * @param array $params
     * @return array
     */
    public function getVideoCategoriesByParams(array $params = []): array;
}
