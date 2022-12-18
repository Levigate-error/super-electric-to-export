<?php

namespace App\Domain\Repositories;

use App\Domain\Repositories\MustHaveGetSource;
use App\Models\Certificate;

/**
 * Interface CertificateRepositoryContract
 * @package App\Domain\Repositories
 */
interface CertificateRepositoryContract extends MustHaveGetSource
{
    /**
     * @param string $code
     * @return Certificate|null
     */
    public function getCertificateByCode(string $code): ?Certificate;
}
