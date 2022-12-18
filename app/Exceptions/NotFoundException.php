<?php

namespace App\Exceptions;

/**
 * Class NotFoundException
 * @package App\Exceptions
 */
class NotFoundException extends AbstractException
{
    protected $code = 404;

    /**
     * @return string
     */
    public function getDefaultMessage(): string
    {
        return trans('errors.no-records');
    }
}
