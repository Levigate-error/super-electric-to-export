<?php

namespace App\Utils\ProductChangers\Watchers;

use Gamez\Illuminate\Support\TypedCollection;
use App\Domain\UtilContracts\ProductChangers\Watchers\Contracts\ProjectProductChangesContract;
use App\Domain\Dictionaries\Utils\ProductChangers\ProjectProductChangeTypes;
use Illuminate\Support\Collection;

/**
 * Class ProjectProductsChangesCollection
 * @package App\Utils\ProductChangers\Watchers
 *
 * Коллекция изменений в товарах проекта. Наример, когда загружается файл со спецификацией проекта, то происходит сравнение
 * параметров товаров в файле с теми, что уже есть в БД в проекте (увеличи цену, уменьшили количество и т.п.). Также
 * добавляет удаление или добавление нового товара.
 */
class ProjectProductsChangesCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [ProjectProductChangesContract::class];

    /**
     * Добавляет изменение параметра товара в коллекцию
     *
     * @param int $projectId                 ID проекта
     * @param string $vendorCode             Артикул товара
     * @param string $name                   Название товара
     * @param string $type                   Тип изменения. App\Domain\Dictionaries\Utils\ProductChangers\ProjectProductChangeTypes
     * @param int|null $productId            ID товара
     * @param array|null $additionalParams   Доп инфа
     * @param null $oldValue                 Старое значение параметра
     * @param null $newValue                 Новое значение параметра
     * @return Collection
     */
    public function pushChange(int $projectId, string $vendorCode, string $name, string $type, int $productId = null,
                               array $additionalParams = null, $oldValue = null, $newValue = null): Collection
    {
        return $this->push(new ProjectProductsChanges($projectId, $vendorCode, $name, $type, $productId, $additionalParams, $oldValue, $newValue));
    }

    /**
     * Шорткат для типа "Позиция добавлена"
     *
     * @param int $projectId
     * @param string $vendorCode
     * @param string $name
     * @param array|null $additionalParams
     * @return Collection
     */
    public function pushAdded(int $projectId, string $vendorCode, string $name, array $additionalParams = null): Collection
    {
        return $this->pushChange($projectId, $vendorCode, $name, ProjectProductChangeTypes::ADDED, null, $additionalParams);
    }

    /**
     * Шорткат для типа "Позиция удалена"
     *
     * @param int $projectId
     * @param string $vendorCode
     * @param string $name
     * @param int $productId
     * @return Collection
     */
    public function pushRemoved(int $projectId, string $vendorCode, string $name, int $productId): Collection
    {
        return $this->pushChange($projectId, $vendorCode, $name, ProjectProductChangeTypes::REMOVED, $productId);
    }

    /**
     * Шорткат для типа "Подобран аналог"
     *
     * @param int $projectId
     * @param string $analogVendorCode
     * @param string $vendorCode
     * @param string $name
     * @param array|null $additionalParams
     * @return Collection
     */
    public function pushAnalog(int $projectId, string $analogVendorCode, string $vendorCode, string $name, array $additionalParams = null): Collection
    {
        return $this->pushChange($projectId, $vendorCode, $name, ProjectProductChangeTypes::ANALOG, null, $additionalParams, $analogVendorCode, $vendorCode);
    }
}
