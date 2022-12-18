<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;
use Gamez\Illuminate\Support\ChecksForValidTypes;

/**
 * Времени не было разбираться, сделал пока быстро, не заморачиваясь. Просто скопировал класс. Суть:
 *
 * В модели есть связь
 * public function loyaltyUserPoint(): BelongsTo
 * {
 * return $this->belongsTo(LoyaltyUserPoint::class);
 * }
 *
 * при отправке письма через нотификации, есть формирование письма
 * public function toMail(LoyaltyUserProposal $userProposal)
 *
 * Где-то под капотом вызывается метод у Illuminate\Database\Eloquent\Relations\BelongsTo
 * @param  \Illuminate\Database\Eloquent\Collection  $results
 * public function match(array $models, Collection $results, $relation)
 *
 * А пакет с типизированной колекцией наследуется от Illuminate\Support\Collection.
 *
 * Поэтому тут валилось.
 *
 * TODO Как спринт завершу, покопаю, возможно получится нормально обойти это.
 *
 * Class EloquentTypedCollection
 * @package Gamez\Illuminate\Support
 */
class EloquentTypedCollection extends Collection
{
    use ChecksForValidTypes;

    public function __construct($items = [])
    {
        parent::__construct($items);

        $this->assertValidTypes();
    }

    public function push($value)
    {
        $this->assertValidType($value);

        return parent::push($value);
    }

    public function offsetSet($key, $value)
    {
        $this->assertValidType($value);

        parent::offsetSet($key, $value);
    }

    public function prepend($value, $key = null)
    {
        $this->assertValidType($value);

        return parent::prepend($value, $key);
    }

    public function add($value)
    {
        $this->assertValidType($value);

        // Using push, because add has only been added after 5.4
        return $this->push($value);
    }

    public function toArray()
    {
        // If the items in the collection are arrayable themselves,
        // toArray() will convert them to arrays as well. If arrays
        // are not allowed in the typed collection, this would
        // fail if we don't untype the collection first
        return $this->untype()->toArray();
    }

    /**
     * Returns an untyped collection with all items
     */
    public function untype()
    {
        return Collection::make($this->items);
    }
}
