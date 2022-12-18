<?php

namespace App\Utils\ProductChangers\Watchers;

use App\Domain\UtilContracts\ProductChangers\Watchers\Contracts\ProjectProductChangesContract;

/**
 * Class ProjectProductsChanges
 * @package App\Utils\ProductChangers\Watchers
 */
class ProjectProductsChanges implements ProjectProductChangesContract
{
    /**
     * @var int
     */
    protected $projectId;

    /**
     * @var int|null
     */
    protected $productId;

    /**
     * @var string
     */
    protected $vendorCode;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed|null
     */
    protected $oldValue;

    /**
     * @var mixed|null
     */
    protected $newValue;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array|null
     */
    protected $additionalParams;

    /**
     * ProjectProductsChanges constructor.
     * @param int $projectId
     * @param string $vendorCode
     * @param string $name
     * @param string $type
     * @param int|null $productId
     * @param array|null $additionalParams
     * @param null $oldValue
     * @param null $newValue
     */
    public function __construct(int $projectId, string $vendorCode, string $name, string $type, int $productId = null,
                                array $additionalParams = null, $oldValue = null, $newValue = null)
    {
        $this->projectId = $projectId;
        $this->vendorCode = $vendorCode;
        $this->name = $name;
        $this->type = $type;
        $this->productId = $productId;
        $this->additionalParams = $additionalParams;
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getVendorCode(): string
    {
        return $this->vendorCode;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return mixed|null
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }

    /**
     * @return mixed|null
     */
    public function getNewValue()
    {
        return $this->newValue;
    }

    /**
     * @return array|null
     */
    public function getAdditionalParams(): ?array
    {
        return $this->additionalParams;
    }
}
