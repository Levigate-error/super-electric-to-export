<?php

namespace App\Observers;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

/**
 * Class BannerObserver
 * @package App\Observers
 */
class BannerObserver
{
    /**
     * @param Banner $banner
     */
    public function deleted(Banner $banner): void
    {
        foreach ($banner->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $banner->images()->delete();
    }
}
