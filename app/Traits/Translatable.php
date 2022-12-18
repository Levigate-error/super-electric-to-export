<?php

namespace App\Traits;

use App\Models\BaseModel;
use Illuminate\Support\Collection;

/**
 * Trait Translatable
 * @package App\Traits
 */
trait Translatable
{
    /**
     * @return bool
     */
    public function checkTranslateEnabled(): bool
    {
        return config('translate.enabled');
    }

    /**
     * Устанавливает перевод текущего объекта
     *
     * @return BaseModel
     */
    public function selfSetupTranslate(): BaseModel
    {
        return static::setupTranslate($this);
    }

    /**
     * Устанавливает перевод объекта
     *
     * @param BaseModel $model
     *
     * @return BaseModel
     */
    public static function setupTranslate(BaseModel $model): BaseModel
    {
        foreach ($model->getTranslatableFields() as $field) {
            $model->{$field} = json_encode($model->{$field});
        }

        return $model;
    }

    /**
     * Переводит текущий объект
     *
     * @param string $locale
     * @return BaseModel
     */
    public function selfTranslate(string $locale = ''): BaseModel
    {
        return $this->translate($this, $locale);
    }

    /**
     * Переводит нужные поля модели под указанную или базовую локаль
     *
     * @param BaseModel $model
     * @param string $locale
     *
     * @return BaseModel
     */
    public function translate(BaseModel $model, string $locale = ''): BaseModel
    {
        if (empty($locale)) {
            $locale = $this->getCurrentLocal();
        }

        foreach ($model->getTranslatableFields() as $field) {
            $model->{$field} = $this->translateField($model->{$field});
        }

        return $model;
    }

    /**
     * Переводит поле под указанную или базовую локаль
     *
     * @param string|null $field
     * @param string $locale
     *
     * @return string
     */
    public function translateField(?string $field, string $locale = ''): string
    {
        if (empty($locale)) {
            $locale = $this->getCurrentLocal();
        }

        $decode = json_decode($field, true);

        return isset($decode[$locale]) ? $decode[$locale] : '';
    }

    /**
     * Определение текущей локали
     *
     * @return string
     */
    public function getCurrentLocal(): string
    {
        $locale = app()->getLocale();

        return $locale;
    }

    /**
     * Переводит нужные поля модели и ее реляций под указанную или базовую локаль
     *
     * @param BaseModel $model
     * @param string $locale
     *
     * @return BaseModel
     */
    public function translateWithRelations(BaseModel $model, string $locale = ''): BaseModel
    {
        if (empty($locale)) {
            $locale = $this->getCurrentLocal();
        }

        $this->translate($model, $locale);

        foreach ($model->getRelations() as $relationValues) {
            $this->translateCollection($relationValues);
        }

        return $model;
    }

    /**
     * Переводит коллекцию моделей
     *
     * @param Collection $collection
     * @param string $locale
     * @return Collection
     */
    public function translateCollection(Collection $collection, string $locale = ''): Collection
    {
        if (empty($locale)) {
            $locale = $this->getCurrentLocal();
        }

        foreach ($collection as $model) {
            $this->translate($model, $locale);
        }

        return $collection;
    }
}
