<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Exception;
use App\Exceptions\NotFoundException;
use App\Exceptions\CanNotSaveException;

/**
 * Class BaseModel
 * @package App\Models
 */
class BaseModel extends Model
{
    /**
     * @var array
     */
    protected $translatableFields = [];

    /**
     * @return array
     */
    public function getTranslatableFields(): array
    {
        return $this->translatableFields;
    }

    /**
     * Поиск по параметрам
     *
     * @param array $params
     *
     * @return BaseModel
     * @throws NotFoundException
     */
    public static function loadByParams(array $params = []): BaseModel
    {
        $model = self::query()->where($params)->get()->first();

        if (empty($model)) {
            throw new NotFoundException();
        }

        return $model;
    }

    /**
     * Список
     *
     * @param array $params
     *
     * @return Collection
     */
    public static function getAll(array $params = []): Collection
    {
        return self::query()->where($params)->get();
    }

    /**
     * Сохранение
     *
     * @return bool
     * @throws CanNotSaveException
     */
    public function trySaveModel(): bool
    {
        try {
            return $this->save();
        } catch (Exception $exception) {
            throw new CanNotSaveException($exception->getMessage());
        }
    }

    /**
     * Сохранение без events
     *
     * @param array $options
     * @return bool
     */
    public function saveQuietly(array $options = []): bool
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }


    /**
     * @param array $params
     * @return static
     */
    public static function store(array $params): self
    {
        $model = new static($params);
        $model->trySaveModel();

        return $model;
    }
}
