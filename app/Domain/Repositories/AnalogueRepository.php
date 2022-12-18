<?php

namespace App\Domain\Repositories;

use App\Collections\AnalogCollection;
use App\Models\Analogue;

/**
 * Interface AnalogueRepository
 * @package App\Domain\Repositories
 */
interface AnalogueRepository extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return AnalogCollection
     */
    public function getAnalogsByParams(array $params): AnalogCollection;

    /**
     * @param array $params
     * @return Analogue|null
     */
    public function getFirstAnalogByParams(array $params): ?Analogue;
}
