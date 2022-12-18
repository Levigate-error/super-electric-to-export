<?php

namespace App\Domain\UtilContracts\Files;

use App\Utils\Files\Collections\Specification\SpecificationCollection;
use App\Utils\Files\Notice\NoticeCollection;
use Illuminate\Http\UploadedFile;

/**
 * Interface FilesProviderContract
 * @package App\Domain\UtilContracts\Files
 */
interface FilesProviderContract
{
    /**
     * Генерирует файл
     *
     * @param int $entityId
     * @return string
     */
    public function generateEntityFile(int $entityId): string;

    /**
     * Получает ссылку на файл
     *
     * @param int $entityId
     * @return string
     */
    public function getEntityFileLink(int $entityId): string;

    /**
     * Проверка файла на соответствие шаблону
     *
     * @param UploadedFile $file
     * @return NoticeCollection
     */
    public function checkFile(UploadedFile $file): NoticeCollection;

    /**
     * Получить ссылку на файл-шаблон
     *
     * @return string
     */
    public function getUrlOfFileExample(): string;

    /**
     * Собирает данные файла по листам из конфига
     *
     * @param UploadedFile $file
     * @return SpecificationCollection
     */
    public function getFileData(UploadedFile $file): SpecificationCollection;
}
