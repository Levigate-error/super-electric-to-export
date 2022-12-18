<?php

namespace App\Services;

use App\Domain\ServiceContracts\SettingServiceContract;
use App\Domain\Repositories\SettingRepositoryContract;

/**
 * Class SettingService
 * @package App\Services
 */
class SettingService extends BaseService implements SettingServiceContract
{
    /**
     * @var SettingRepositoryContract
     */
    private $repository;

    /**
     * SettingService constructor.
     * @param SettingRepositoryContract $repository
     */
    public function __construct(SettingRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return SettingRepositoryContract
     */
    public function getRepository(): SettingRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getValueByKey(string $key): string
    {
        $setting = $this->repository->getByKey($key);

        if ($setting === null) {
            return '';
        }

        return $setting->value;
    }
}
