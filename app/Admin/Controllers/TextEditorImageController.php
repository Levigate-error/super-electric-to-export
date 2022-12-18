<?php

namespace App\Admin\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use App\Admin\Requests\UploadFileRequest;

/**
 * Class TextEditorImageController
 * @package App\Admin\Controllers
 */
class TextEditorImageController
{
    /**
     * @param UploadFileRequest $request
     * @return JsonResponse
     */
    public function upload(UploadFileRequest $request): JsonResponse
    {
        $file = $request->validated()['upload'];

        Storage::disk('public')->put('/files/', $file);

        return response()->json([
            'uploaded' => 1,
            'fileName' => $file->hashName(),
            'url' => Storage::disk('public')->url('/files/' . $file->hashName()),
        ]);
    }
}
