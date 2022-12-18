<?php

namespace Database\Seeds\Import\Catalog;

use \Database\Seeds\Import\Catalog\CatalogType as Type;

class CatalogField
{
    protected static $lang = 'ru';

    public static function setLang(string $lang): void
    {
        static::$lang = $lang;
    }


    public static function category(): CatalogType
    {
        return new Type('category');
    }

    public static function division(): Type
    {
        return new Type('division');
    }

    public static function familyCode(): Type
    {
        return new Type('family_code');
    }

    public static function vendorCode(): Type
    {
        return new Type('vendor_code');
    }

    public static function familyName(): Type
    {
        return new Type('family_name');
    }

    public static function name(): Type
    {
        return new Type('name');
    }

    public static function familyNumber(): Type
    {
        return new Type('family_number');
    }

    public static function recommendedRetailPrice(): Type
    {
        return new Type('recommended_retail_price', Type::TYPE_FLOAT);
    }

    public static function unit($default): Type
    {
        return new Type('unit', Type::TYPE_STRING, $default);
    }

    public static function minAmount(): Type
    {
        return new Type('min_amount', Type::TYPE_INTEGER);
    }

    public static function commercialPage(): Type
    {
        $type = new Type('files', Type::TYPE_FILE);
        $type->setDescription(trans('settings.commercial-pages'));
        return $type;
    }

    public static function instruction(string $comment = null): Type
    {
        $type = new Type('files', Type::TYPE_FILE);
        $type->setDescription(trans('settings.instructions'));

        if ($comment) {
            $type->setComment($comment);
        }

        return $type;
    }

    public static function certificate(string $comment = null, bool $commentFromTitle = false): Type
    {
        $type = new Type('files', Type::TYPE_FILE);
        $type->setDescription(trans('settings.certificate'));

        if ($comment) {
            $type->setComment($comment);
        }

        if ($commentFromTitle === true) {
            $type->setCommentFromTitle();
        }

        return $type;
    }

    /**
     * Видео ролики
     * @param string|null $comment
     * @param bool $commentFromTitle
     * @return CatalogType
     */
    public static function video(string $comment = null, bool $commentFromTitle = false): Type
    {
        $type = new Type('files', Type::TYPE_FILE);
        $type->setDescription(trans('settings.videos'));

        if ($comment) {
            $type->setComment($comment);
        }

        if ($commentFromTitle === true) {
            $type->setCommentFromTitle();
        }

        return $type;
    }

    /**
     * Изображения товара
     * @return CatalogType
     */
    public static function image(): Type
    {
        $type = new Type('files', Type::TYPE_FILE);
        $type->setDescription(100);
        $type->setPropertyType('Image');

        return $type;
    }

    public static function property(): Type
    {
        return new Type('properties', Type::TYPE_PROPERTY);
    }


}
