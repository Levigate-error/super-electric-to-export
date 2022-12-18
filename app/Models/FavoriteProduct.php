<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class FavoriteProduct
 * @package App\Models
 */
class FavoriteProduct extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'product_id'];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param int $productId
     * @param int $userId
     * @return bool
     */
    public static function addProductToFavorite(int $productId, int $userId): bool
    {
        return self::query()->firstOrNew([
            'user_id' => $userId,
            'product_id' => $productId,
        ])->trySaveModel();
    }

    /**
     * @param int $productId
     * @param int $userId
     *
     * @return bool|null
     * @throws \Exception
     */
    public static function removeProductFromFavorite(int $productId, int $userId)
    {
        return self::loadByParams([
            'user_id' => $userId,
            'product_id' => $productId,
        ])->delete();
    }
}
