<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Imagick;
use Illuminate\Filesystem\FilesystemAdapter;

/**
 * Trait ImagePrepare
 * @package App\Traits
 */
trait ImagePrepare
{
    /**
     * @param  string  $imagePath
     * @param  FilesystemAdapter|null  $filesystemAdapter
     * @throws \ImagickException
     */
    protected function rotateImageToTopLeft(string $imagePath, ?FilesystemAdapter $filesystemAdapter = null): void
    {
        $filesystemAdapter = $filesystemAdapter ?? Storage::disk('public');

        $path = $filesystemAdapter->path($imagePath);

        $image = new Imagick($path);

        $orientation = $image->getImageOrientation();
        switch($orientation) {
            case Imagick::ORIENTATION_BOTTOMRIGHT:
                $image->rotateimage('#000', 180);
                break;
            case Imagick::ORIENTATION_RIGHTTOP:
                $image->rotateimage('#000', 90);
                break;
            case Imagick::ORIENTATION_LEFTBOTTOM:
                $image->rotateimage('#000', -90);
                break;
        }

        $image->setImageOrientation(Imagick::ORIENTATION_TOPLEFT);
        $image->writeImage($path);
        $image->clear();
        $image->destroy();
    }
}
