<?php

namespace App\Services;

use App\Domain\ServiceContracts\FaqServiceContract;
use App\Domain\Repositories\FaqRepositoryContract;
use App\Http\Resources\FaqResource;

/**
 * Class FaqService
 * @package App\Services
 */
class FaqService extends BaseService implements FaqServiceContract
{
    /**
     * @var FaqRepositoryContract
     */
    private $repository;

    /**
     * FaqService constructor.
     * @param FaqRepositoryContract $repository
     */
    public function __construct(FaqRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return FaqRepositoryContract
     */
    public function getRepository(): FaqRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return array
     */
    public function getFaqsByParams(array $params = []): array
    {
        $faqs = $this->repository->getByParams($params);

        return [
            'total' => $faqs->total(),
            'lastPage' => $faqs->lastPage(),
            'currentPage' => $faqs->currentPage(),
            'faqs' => FaqResource::collection($faqs->untype())->resolve(),
        ];
    }
}
