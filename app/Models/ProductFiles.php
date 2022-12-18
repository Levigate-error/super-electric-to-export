<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductFiles
 * @package App\Models
 */
class ProductFiles extends BaseModel
{
    /**
     * @var array '
     */
    protected $translatableFields = ['comment', 'description'];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
