<?php

namespace App\Domain\ServiceContracts\Imports\Avito;

use App\Admin\Services\User\Imports\ImportResult;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Exception;

/**
 * Interface AvitoUserImportServiceContract
 *
 * Контракт импорта пользователей Авито из файла.
 *
 * @package App\Domain\ServiceContracts\Imports\Avito
 */
interface AvitoUserImportServiceContract
{
    /**
     * Начать импорт из файла.
     *
     * @param UploadedFile $file
     *
     * @return ImportResult
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function run(UploadedFile $file): ImportResult;
}
