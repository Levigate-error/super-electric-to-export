<?php

namespace App\Traits;

/**
 * Trait HasSourceGetter
 * @package App\Traits
 */
trait HasSourceGetter
{
    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }
}
