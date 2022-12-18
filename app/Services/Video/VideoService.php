<?php

namespace App\Services\Video;

use App\Http\Resources\Video\VideoResource;
use App\Services\BaseService;
use App\Domain\ServiceContracts\Video\VideoServiceContract;
use App\Domain\Repositories\Video\VideoRepositoryContract;

/**
 * Class VideoService
 * @package App\Services\Video
 */
class VideoService extends BaseService implements VideoServiceContract
{
    /**
     * @var VideoRepositoryContract
     */
    private $repository;

    /**
     * VideoService constructor.
     * @param VideoRepositoryContract $repository
     */
    public function __construct(VideoRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return VideoRepositoryContract
     */
    public function getRepository(): VideoRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getVideosByParams(array $params = []): array
    {
        $videos = $this->repository->getByParams($params);

        return [
            'total' => $videos->total(),
            'lastPage' => $videos->lastPage(),
            'currentPage' => $videos->currentPage(),
            'videos' => VideoResource::collection($videos->untype())->resolve(),
        ];
    }
}
