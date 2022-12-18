<?php

namespace App\Admin\Services\User\Imports;

/**
 * Class ImportResult
 *
 * Результат импорта.
 *
 * @package App\Admin\Services\User\Imports
 */
class ImportResult
{
    /**
     * @var int
     */
    protected $parsedCount;

    /**
     * @var int
     */
    protected $importedCount;

    public function __construct(int $parsedCount, int $importedCount)
    {
        $this->parsedCount = $parsedCount;
        $this->importedCount = $importedCount;
    }

    /**
     * @return int
     */
    public function getParsedCount(): int
    {
        return $this->parsedCount;
    }

    /**
     * @return int
     */
    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('admin.imports.import_succeeded', [
            'current' => $this->getImportedCount(),
            'total'   => $this->getParsedCount(),
        ]);
    }
}
