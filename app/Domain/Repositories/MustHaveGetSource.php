<?php

namespace App\Domain\Repositories;

/**
 * Interface MustHaveGetSource
 * @package App\Domain\Repositories
 */
interface MustHaveGetSource
{
    /**
     * @return string
     */
    public function getSource(): string;
}
