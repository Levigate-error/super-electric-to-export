<?php

namespace App\Domain\ServiceContracts;

use App\Domain\Repositories\AnalogueRepository;

/**
 * Interface AnalogueServiceContract
 * @package App\Domain\ServiceContracts
 */
interface AnalogueServiceContract
{
    /**
     * @return AnalogueRepository
     */
    public function getRepository(): AnalogueRepository;

    /**
     * @param array $params
     * @return mixed
     */
    public function search(array $params);

    /**
     * @param array $params
     * @return array|null
     */
    public function getFirstProductByParams(array $params): ?array;
}
