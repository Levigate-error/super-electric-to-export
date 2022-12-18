<?php

namespace App\Domain\Repositories;

use App\Models\Setting;

/**
 * Interface SettingRepositoryContract
 * @package App\Domain\Repositories
 */
interface SettingRepositoryContract extends MustHaveGetSource
{
    /**
     * @param string $key
     * @return Setting|null
     */
    public function getByKey(string $key): ?Setting;
}
