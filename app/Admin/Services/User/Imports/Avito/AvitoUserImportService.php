<?php

namespace App\Admin\Services\User\Imports\Avito;

use App\Admin\Services\User\Imports\ImportResult;
use App\Domain\ServiceContracts\Imports\Avito\AvitoUserImportServiceContract;
use App\Domain\ServiceContracts\Imports\Avito\AvitoUserParserContract;
use App\Domain\ServiceContracts\Imports\Avito\AvitoUserSaverContract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class AvitoUserImportService
 *
 * Сервис импорта пользователей Авито из файла.
 *
 * @package App\Admin\Services\User\Imports\Avito
 */
class AvitoUserImportService implements AvitoUserImportServiceContract
{
    /**
     * @var AvitoUserParserContract
     */
    protected $parser;

    /**
     * @var AvitoUserSaverContract
     */
    protected $saver;

    public function __construct(AvitoUserParserContract $parser, AvitoUserSaverContract $saver)
    {
        $this->parser = $parser;
        $this->saver = $saver;
    }

    /**
     * Начать импорт из файла.
     *
     * @param UploadedFile $file
     *
     * @return ImportResult
     */
    public function run(UploadedFile $file): ImportResult
    {
        $path = Storage::disk()->putFile('user_imports', $file);
        $avitoUserCollection = $this->parser->parse($path);
        Storage::disk()->delete($path);
        $count = $this->saver->batchSave($avitoUserCollection);

        return new ImportResult($avitoUserCollection->count(), $count);
    }


}
