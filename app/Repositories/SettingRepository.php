<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Domain\Repositories\SettingRepositoryContract;

/**
 * Class SettingRepository
 * @package App\Repositories
 */
class SettingRepository extends BaseRepository implements SettingRepositoryContract
{
    protected $source = Setting::class;

    /**
     * @param string $key
     * @return Setting|null
     */
    public function getByKey(string $key): ?Setting
    {
        return $this->getQueryBuilder()->where([
            'key' => $key,
        ])->first();
    }
}
