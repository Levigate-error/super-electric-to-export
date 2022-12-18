<?php

namespace App\Domain\ServiceContracts;

use App\Domain\Repositories\SettingRepositoryContract;

/**
 * Interface SettingServiceContract
 * @package App\Domain\ServiceContracts
 */
interface SettingServiceContract
{
    /**
     * @return SettingRepositoryContract
     */
    public function getRepository(): SettingRepositoryContract;

    /**
     * @param string $key
     * @return string
     */
    public function getValueByKey(string $key): string;
}
