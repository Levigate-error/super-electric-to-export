<?php

namespace App\Http\Requests\Video;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VideoSearchRequest
 * @package App\Http\Requests\Video
 */
class VideoSearchRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'video_category_id' => 'integer|exists:video_categories,id',
            'limit' => 'integer',
            'page' => 'integer',
            'search' => 'string',
        ];
    }
}
