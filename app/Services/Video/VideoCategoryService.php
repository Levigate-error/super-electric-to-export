<?php

namespace App\Services\Video;

use App\Http\Resources\Video\VideoCategoryResource;
use App\Services\BaseService;
use App\Domain\ServiceContracts\Video\VideoCategoryServiceContract;
use App\Domain\Repositories\Video\VideoCategoryRepositoryContract;

/**
 * Class VideoCategoryService
 * @package App\Services\Video
 */
class VideoCategoryService extends BaseService implements VideoCategoryServiceContract
{
    /**
     * @var VideoCategoryRepositoryContract
     */
    private $repository;

    /**
     * VideoCategoryService constructor.
     * @param VideoCategoryRepositoryContract $repository
     */
    public function __construct(VideoCategoryRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return VideoCategoryRepositoryContract
     */
    public function getRepository(): VideoCategoryRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getVideoCategoriesByParams(array $params = []): array
    {
        $videoCategories = $this->repository->getByParams($params);

        return VideoCategoryResource::collection($videoCategories->untype())->resolve();
    }
}
