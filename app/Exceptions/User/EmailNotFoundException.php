<?php

namespace App\Exceptions\User;

use App\Exceptions\AbstractException;

/**
 * Class EmailNotFoundException
 * @package App\Exceptions\User
 */
class EmailNotFoundException extends AbstractException
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
