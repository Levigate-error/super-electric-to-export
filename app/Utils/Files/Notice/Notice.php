<?php

namespace App\Utils\Files\Notice;

use Illuminate\Contracts\Support\Jsonable;

/**
 * Class Notice
 * @package App\Utils\Files\Notice
 */
class Notice implements Jsonable
{
    /**
     * @var string
     */
    protected $level;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var ?string
     */
    protected $additional;

    /**
     * Notice constructor.
     * @param string $level
     * @param string $text
     * @param string|null $additional
     */
    public function __construct(string $level, string $text, string $additional = null)
    {
        $this->level = $level;
        $this->text = $text;
        $this->additional = $additional;
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string|null
     */
    public function getAdditional(): ?string
    {
        return $this->additional;
    }

    /**
     * @param int $options
     * @return false|string
     */
    public function toJson($options = 0)
    {
        return json_encode(get_object_vars($this));
    }
}
