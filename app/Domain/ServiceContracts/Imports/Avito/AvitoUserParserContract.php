<?php

namespace App\Domain\ServiceContracts\Imports\Avito;

use App\Admin\Services\User\Imports\Avito\AvitoUserCollection;

/**
 * Interface AvitoUserParserContract
 *
 * Контракт парсера выгрузки юзеров Авито.
 *
 * @package App\Domain\ServiceContracts\Imports\Avito
 */
interface AvitoUserParserContract
{
    /**
     * Парсить файл выгрузки Авито.
     *
     * @param string $fileName
     *
     * @return AvitoUserCollection
     */
    public function parse(string $fileName): AvitoUserCollection;
}
