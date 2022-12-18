<?php

namespace App\Exceptions;

/**
 * Class CanNotSaveException
 * @package App\Exceptions
 */
class CanNotSaveException extends AbstractException
{
    protected $code = 500;

    /**
     * @return string
     */
    public function getDefaultMessage(): string
    {
        return trans('errors.can-not-save');
    }
}
