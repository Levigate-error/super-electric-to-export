<?php

namespace App\Models\Project;

use App\Models\BaseModel;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Utils\ProductChangers\Watchers\ProjectProductsChangesCollection;
use App\Domain\UtilContracts\ProductChangers\Watchers\Contracts\ProjectProductChangesContract;
use Illuminate\Support\Collection;
use App\Domain\Dictionaries\Utils\ProductChangers\ProjectProductChangeTypes;

/**
 * Class ProjectProductChange
 * @package App\Models\Project
 */
class ProjectProductChange extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['project_id', 'product_id', 'vendor_code', 'name', 'old_value', 'new_value', 'type', 'used', 'additional_params'];

    /**
     * @return HasOne
     */
    public function project(): HasOne
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    /**
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Product::class,'id',  'product_id');
    }

    /**
     * Тип изменения на человеко-понятном языке
     *
     * @return string
     */
    public function getTypeOnHumanAttribute(): string
    {
        return ProjectProductChangeTypes::toHuman($this->type);
    }

    /**
     * Создаем записи на основе коллекции изменений в товарах
     *
     * @param ProjectProductsChangesCollection $changesCollection
     * @return Collection
     */
    public static function addChanges(ProjectProductsChangesCollection $changesCollection): Collection
    {
        $models = new Collection();

        foreach ($changesCollection as $changes) {
            /**
             * @var $changes ProjectProductChangesContract
             */
            $model = new self();

            $model->fill([
                'project_id' => $changes->getProjectId(),
                'product_id' => $changes->getProductId(),
                'vendor_code' => $changes->getVendorCode(),
                'name' => $changes->getName(),
                'old_value' => $changes->getOldValue(),
                'new_value' => $changes->getNewValue(),
                'type' => $changes->getType(),
                'additional_params' => json_encode($changes->getAdditionalParams()),
            ])->save();

            $models->push($model);
        }

        return $models;
    }

    /**
     * @param bool $used
     * @return bool
     */
    public function setUsed($used = true): bool
    {
        $this->used = $used;
        return $this->trySaveModel();
    }
}
