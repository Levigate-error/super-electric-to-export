<?php

namespace App\Services;

use App\Domain\ServiceContracts\NewsServiceContract;
use App\Domain\Repositories\NewsRepositoryContract;
use App\Http\Resources\NewsResource;

/**
 * Class FaqService
 * @package App\Services
 */
class NewsService extends BaseService implements NewsServiceContract
{
    /**
     * @var NewsRepositoryContract
     */
    private $repository;

    /**
     * FaqService constructor.
     * @param NewsRepositoryContract $repository
     */
    public function __construct(NewsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return NewsRepositoryContract
     */
    public function getRepository(): NewsRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @inheritDoc
     */
    public function getNewsByParams(array $params = []): array
    {
        $news = $this->repository->getByParams($params);

        return [
            'total' => $news->total(),
            'lastPage' => $news->lastPage(),
            'currentPage' => $news->currentPage(),
            'news' => NewsResource::collection($news->untype())->resolve(),
        ];
    }

    /**
     * @param int $newsId
     * @return array
     */
    public function getNewsDetails(int $newsId): array
    {
        $news = $this->repository->getById($newsId);

        return NewsResource::make($news)->resolve();
    }
}
