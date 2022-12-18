<?php

namespace App\Repositories;

use App\Collections\BannerCollection;
use App\Models\Banner;
use App\Domain\Repositories\BannerRepositoryContract;

/**
 * Class BannerRepository
 * @package App\Repositories
 */
class BannerRepository extends BaseRepository implements BannerRepositoryContract
{
    protected $source = Banner::class;

    /**
     * @param array $params
     * @return BannerCollection
     */
    public function getListByParams(array $params): BannerCollection
    {
        $query = $this->getQueryBuilder();

        if (isset($params['for_registered']) === true) {
            $query->registered($params['for_registered']);
            unset($params['for_registered']);
        }

        if (isset($params['published']) === true) {
            $query->published($params['published']);
            unset($params['published']);
        }

        return $query
            ->where($params)
            ->get();
    }
}
