<?php

namespace App\Services;

use App\Domain\ServiceContracts\BannerServiceContract;
use App\Domain\Repositories\BannerRepositoryContract;
use App\Http\Resources\BannerResource;
use Illuminate\Support\Facades\Auth;

/**
 * Class BannerService
 * @package App\Services
 */
class BannerService extends BaseService implements BannerServiceContract
{
    /**
     * @var BannerRepositoryContract
     */
    private $repository;

    /**
     * BannerService constructor.
     * @param BannerRepositoryContract $repository
     */
    public function __construct(BannerRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return BannerRepositoryContract
     */
    public function getRepository(): BannerRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @return array
     */
    public function getListForCurrentUser(): array
    {
        $user = Auth::user();

        $params = [
            'for_registered' => true,
            'published' => true,
        ];
        if ($user === null) {
            $params['for_registered'] = false;
        }

        return $this->getListByParams($params);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getListByParams(array $params): array
    {
        $banners = $this->repository->getListByParams($params);

        return BannerResource::collection($banners->untype())->resolve();
    }
}
