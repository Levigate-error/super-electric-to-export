<?php

namespace App\Utils\Synchronizations;

use BadMethodCallException;
use BadFunctionCallException;
use Illuminate\Support\Facades\Log;

/**
 * Class AbstractProvider
 * @package App\Utils\Synchronizations
 */
abstract class AbstractProvider
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var bool
     */
    protected $debugMode = false;

    /**
     * AbstractProvider constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        if (isset($config['debug'])) {
            $this->debugMode = $config['debug'];
        }
    }

    /**
     * @return bool
     */
    abstract public function checkInit(): bool;

    /**
     * @return string
     */
    abstract public function getProviderCode(): string;

    /**
     * @param $method
     * @param $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $methodToCall = $method . 'Processing';

        if (!method_exists($this, $methodToCall)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $methodToCall
            ));
        }

        if (!$this->checkInit()) {
            throw new BadFunctionCallException(sprintf(
                'Before call method %s::%s you must init object.', static::class, $methodToCall
            ));
        }

        return call_user_func_array([$this, $methodToCall], $parameters);
    }

    /**
     * @param string $channel
     * @param string $title
     * @param array $content
     */
    protected function logError(string $channel, string $title, array $content): void
    {
        Log::channel($channel)->warning($title, $content);
    }
}
