<?php

namespace App\Repositories\Video;

use App\Repositories\BaseRepository;
use App\Models\Video\Video;
use App\Domain\Repositories\Video\VideoRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class VideoRepository
 * @package App\Repositories\Video
 */
class VideoRepository extends BaseRepository implements VideoRepositoryContract
{
    protected $source = Video::class;

    /**
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getByParams(array $params = []): LengthAwarePaginator
    {
        $locale = get_current_local();

        $query = $this->getQueryBuilder()
            ->published()
            ->orderBy("title->" . $locale);

        if (isset($params['search']) === true) {
            $query->where("title->$locale", 'ILIKE', "%{$params['search']}%");
        }

        if (isset($params['video_category_id']) === true) {
            $query->where(['video_category_id' => $params['video_category_id']]);
        }

        if (isset($params['limit']) === true) {
            $limit = $this->prepareLimit($params['limit']);

            return $query->paginate($limit);
        }

        return $query->paginate();
    }
}
