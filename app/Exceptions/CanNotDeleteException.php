<?php

namespace App\Exceptions;

/**
 * Class CanNotDeleteException
 * @package App\Exceptions
 */
class CanNotDeleteException extends AbstractException
{
    protected $code = 500;

    /**
     * @return string
     */
    public function getDefaultMessage(): string
    {
        return trans('errors.can-not-delete');
    }
}
