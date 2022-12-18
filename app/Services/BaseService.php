<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Traits\ServiceGetter;
use App\Traits\HasCache;

/**
 * Class BaseService
 * @package App\Services
 */
abstract class BaseService
{
    use ServiceGetter;
    use HasCache;

    /**
     * @param UploadedFile $file
     * @return string
     */
    protected function generateFilePath(UploadedFile $file): string
    {
        return static::FILE_DIR . time() . '_' . $file->getBasename() . '.' . $file->getClientOriginalExtension();
    }
}
