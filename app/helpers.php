<?php

use App\Models\BaseModel;
use Illuminate\Support\Collection;

if (!function_exists('translate')) {
    /**
     * Переводит нужные поля модели под указанную или базовую локаль
     *
     * @param BaseModel $model
     * @param string    $locale
     *
     * @return BaseModel
     */
    function translate(BaseModel $model, string $locale = '')
    {
        if (empty($locale)) {
            $locale = get_current_local();
        }

        foreach ($model->getTranslatableFields() as $field) {
            $model->{$field} = translate_field($model->{$field});
        }

        return $model;
    }
}

if (!function_exists('translate_field')) {
    /**
     * Переводит поле под указанную или базовую локаль
     *
     * @param string|null $field
     * @param string      $locale
     *
     * @return string
     */
    function translate_field(?string $field, string $locale = '')
    {
        if (empty($locale)) {
            $locale = get_current_local();
        }

        $decode = json_decode($field, true);

        return isset($decode[$locale]) ? $decode[$locale] : '';
    }
}

if (!function_exists('setup_translate')) {
    /**
     * Устанавливает перевод модели под указанную или базовую локаль
     *
     * @param BaseModel $model
     * @param string    $locale
     *
     * @return BaseModel
     */
    function setup_translate(BaseModel $model, string $locale = '')
    {
        if (empty($locale)) {
            $locale = get_current_local();
        }

        foreach ($model->getTranslatableFields() as $field) {
            $encode = json_encode([$locale => $model->{$field}]);
            $model->{$field} = $encode;
        }

        return $model;
    }
}


if (!function_exists('get_current_local')) {
    /**
     * Определение текущей локали
     *
     * @return string
     */
    function get_current_local()
    {
        $locale = app()->getLocale();

        return $locale;
    }
}

if (!function_exists('translate_with_relations')) {
    /**
     * Переводит нужные поля модели и ее реляций под указанную или базовую локаль
     *
     * @param BaseModel $model
     * @param string    $locale
     *
     * @return BaseModel
     */
    function translate_with_relations(BaseModel $model, string $locale = '')
    {
        if (empty($locale)) {
            $locale = get_current_local();
        }

        translate($model, $locale);

        foreach ($model->getRelations() as $relationValues) {
            translate_collection($relationValues);
        }

        return $model;
    }
}

if (!function_exists('translate_collection')) {
    /**
     * Переводит коллекцию моделей
     *
     * @param Collection $collection
     * @param string $locale
     * @return Collection
     */
    function translate_collection(Collection $collection, string $locale = '')
    {
        if (empty($locale)) {
            $locale = get_current_local();
        }

        foreach ($collection as $model) {
            translate($model, $locale);
        }

        return $collection;
    }
}

if (!function_exists('setup_field_translate')) {
    /**
     * Устанавливает перевод поля под указанную или базовую локаль
     *
     * @param string $field
     * @param string $locale
     * @return false|string
     */
    function setup_field_translate(string $field, string $locale = '')
    {
        if (empty($locale)) {
            $locale = get_current_local();
        }

        return json_encode([$locale => $field]);
    }
}

if (!function_exists('sort_by_first_element')) {
    /**
     * Сортировка по первому элеметну. Например, 42 мм, 220 мм отсортирует в корректном порядке.
     *
     * @param Collection $collection
     * @param string $field
     * @return Collection
     */
    function sort_by_first_element(Collection $collection, string $field): Collection
    {
        return $collection->sortBy(static function ($value, $key) use ($field) {
            $explode = explode(' ', $value->{$field});

            return $explode[0];
        });
    }
}

if (!function_exists('delete_transitions_from_text')) {
    /**
     * Удаляет пробелы, табуляцию, новые строки из текста.
     *
     * @param string $text
     * @return string
     */
    function delete_transitions_from_text(string $text): string
    {
        return trim(str_replace(["\r\n", "\r", "\n", "\t"], '', $text));
    }
}
