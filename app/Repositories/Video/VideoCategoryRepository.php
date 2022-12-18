<?php

namespace App\Repositories\Video;

use App\Collections\Video\VideoCategoryCollection;
use App\Repositories\BaseRepository;
use App\Models\Video\VideoCategory;
use App\Domain\Repositories\Video\VideoCategoryRepositoryContract;

/**
 * Class VideoCategoryRepository
 * @package App\Repositories\Video
 */
class VideoCategoryRepository extends BaseRepository implements VideoCategoryRepositoryContract
{
    protected $source = VideoCategory::class;

    /**
     * @param array $params
     * @return VideoCategoryCollection
     */
    public function getByParams(array $params = []): VideoCategoryCollection
    {
        $locale = get_current_local();

        return $this->getQueryBuilder()
            ->published()
            ->where($params)
            ->orderBy("title->" . $locale)
            ->get();
    }
}
