<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

/**
 * Class AbstractException
 * @package App\Exceptions
 */
abstract class AbstractException extends HttpException
{
    protected $message;

    protected $code = 500;

    /**
     * AbstractException constructor.
     *
     * @param string         $message
     * @param int            $statusCode
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $statusCode = 0, Throwable $previous = null)
    {
        $message = strlen($message) === 0 ? $this->getDefaultMessage() : $message;
        $statusCode = $statusCode === 0 ? $this->getCode() : $statusCode;

        parent::__construct($statusCode, $message, $previous);
    }

    /**
     * @return string
     */
    abstract function getDefaultMessage(): string;
}
