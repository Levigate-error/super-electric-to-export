<?php

namespace App\Collections;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Feedback;

/**
 * Class FeedbackCollection
 * @package App\Collections
 */
class FeedbackCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [Feedback::class];
}
