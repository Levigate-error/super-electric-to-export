<?php

namespace App\Admin\Services\User\Imports;

use Webmozart\Assert\Assert;

/**
 * Class BaseCollection
 *
 * @package App\Admin\DataObjects
 */
abstract class BaseCollection
{
    protected $elements = [];

    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
    }

    /**
     * Добавить элемент.
     *
     * @param $element
     *
     * @return BaseCollection
     */
    public function addElement($element): self
    {
        Assert::isInstanceOf($element, $this->getElementClassName());
        $this->elements[] = $element;

        return $this;
    }

    /**
     * @return $this
     */
    public function clear(): self
    {
        $this->elements = [];

        return $this;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->elements;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->elements);
    }

    /**
     * Получить имя класса элемента.
     *
     * @return string
     */
    abstract protected function getElementClassName(): string;
}
