<?php

namespace App\Services;

use App\Domain\ServiceContracts\AnalogueServiceContract;
use App\Domain\Repositories\AnalogueRepository;
use App\Http\Resources\AnalogResource;
use App\Exceptions\NotFoundException;
use Illuminate\Support\Facades\Mail;
use App\Mail\AnalogueNotFound;

/**
 * Class AnalogueService
 * @package App\Services
 */
class AnalogueService extends BaseService implements AnalogueServiceContract
{
    /**
     * @var AnalogueRepository
     */
    private $repository;

    /**
     * AnalogService constructor.
     * @param AnalogueRepository $repository
     */
    public function __construct(AnalogueRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return AnalogueRepository
     */
    public function getRepository(): AnalogueRepository
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return array|mixed
     */
    public function search(array $params)
    {
        $analogs = $this->repository->getAnalogsByParams($params);

        if ($analogs->isEmpty()) {
            Mail::send(new AnalogueNotFound($params));

            throw new NotFoundException(__('analog.not-found.no-records'));
        }

        return AnalogResource::collection($analogs->untype())->resolve();
    }

    /**
     * @param array $params
     * @return array|null
     */
    public function getFirstProductByParams(array $params): ?array
    {
        $analog = $this->repository->getFirstAnalogByParams($params);

        if ($analog === null) {
            return null;
        }

        return $analog->products->first()->toArray();
    }
}
