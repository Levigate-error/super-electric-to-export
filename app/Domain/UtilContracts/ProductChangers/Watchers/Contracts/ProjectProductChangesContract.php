<?php

namespace App\Domain\UtilContracts\ProductChangers\Watchers\Contracts;

/**
 * Interface ProjectProductChangesContract
 * @package App\Domain\UtilContracts\ProductChangers\Watchers\Contracts
 */
interface ProjectProductChangesContract
{
    /**
     * @return int
     */
    public function getProjectId(): int;

    /**
     * @return int|null
     */
    public function getProductId(): ?int;

    /**
     * @return string
     */
    public function getVendorCode(): string;

    /**
     * @return string
     */
    public function getName(): string;
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return mixed|null
     */
    public function getOldValue();

    /**
     * @return mixed|null
     */
    public function getNewValue();

    /**
     * @return array|null
     */
    public function getAdditionalParams(): ?array;
}
