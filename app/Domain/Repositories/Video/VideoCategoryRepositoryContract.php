<?php

namespace App\Domain\Repositories\Video;

use App\Collections\Video\VideoCategoryCollection;
use App\Domain\Repositories\MustHaveGetSource;

/**
 * Interface VideoCategoryRepositoryContract
 * @package App\Domain\Repositories\Video
 */
interface VideoCategoryRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return VideoCategoryCollection
     */
    public function getByParams(array $params = []): VideoCategoryCollection;
}
