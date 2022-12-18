<?php

namespace Database\Seeds\Import\Catalog;


class CatalogType
{
    public const PROPERTY_TYPE_IMAGE = 'Image';
    protected const DEFAULT_UNIT = [
        'ru' => 'ШТ',
    ];


    public $method;
    public $type;
    public $field;
    public $default;
    public $description;
    public $comment = null;

    private $propertyType = 'Add. file';
    private $value;
    private $title;
    private $setCommentFromTitle = false;
    private $sortField = 100;

    public const
        TYPE_STRING = 'string',
        TYPE_INTEGER = 'int',
        TYPE_FLOAT = 'float',
        TYPE_FILE = 'file',
        TYPE_PROPERTY = 'property';

    public function __construct(
        string $field,
        string $type = self::TYPE_STRING,
        string $default = ''
    )
    {
        $this->field = $field;
        $this->type = $type;
        $this->default = $default;
    }

    public function title(string $title): CatalogType
    {
        $this->title = trim($title);

        return $this;
    }

    public function value(string $value): CatalogType
    {
        $this->value = trim($value);

        if ($this->default && empty($this->value)) {
            $this->value = $this->default;
        }

        return $this;
    }

    /**
     * Форматирует данные
     * @return string|float|int|array|null
     */
    public function formatted()
    {
        $description = $params['description'] ?? $this->description;

        if ($this->type === self::TYPE_FLOAT) {
            return (float)$this->value;
        }

        if ($this->type === self::TYPE_INTEGER) {
            return (int)$this->value;
        }


        if ($this->type === self::TYPE_FILE) {
            //Если установлен флаг брать из заголовка, то формируем другой комментарий
            if ($this->setCommentFromTitle === true) {
                $this->comment = $this->title;
            }

            if ($this->propertyType === self::PROPERTY_TYPE_IMAGE) {
                $this->description = $this->sortField;
            }

            return [
                'type' => $this->propertyType,
                'description' => $description,
                'file_link' => $this->value,
                'comment' => $this->comment
            ];
        }

        if ($this->type === self::TYPE_PROPERTY) {
            return [
                'title' => $this->title,
                'value' => $this->value,
            ];
        }

        return $this->value;
    }

    public function getPropertyType(): string
    {
        return $this->propertyType;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Признак устанавливать ли комментарий из заголовка документа
     * @param bool $value
     * @return CatalogType
     */
    public function setCommentFromTitle(bool $value = true): self
    {
        $this->setCommentFromTitle = $value;
        return $this;
    }

    public function setPropertyType(string $string): self
    {
        $this->propertyType = $string;
        return $this;
    }

    public function setSortField(int $sort): self
    {
        $this->sortField = $sort;
        return $this;
    }
}
