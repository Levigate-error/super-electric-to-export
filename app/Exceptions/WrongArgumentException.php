<?php

namespace App\Exceptions;

/**
 * Class WrongArgumentException
 * @package App\Exceptions
 */
class WrongArgumentException extends AbstractException
{
    protected $code = 500;

    /**
     * @return string
     */
    public function getDefaultMessage(): string
    {
        return trans('errors.wrong-argument');
    }
}
