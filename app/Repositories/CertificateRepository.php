<?php

namespace App\Repositories;

use App\Domain\Repositories\CertificateRepositoryContract;
use App\Models\Certificate;
use App\Repositories\BaseRepository;

/**
 * Class CertificateRepository
 * @package App\Repositories
 */
class CertificateRepository extends BaseRepository implements CertificateRepositoryContract
{
    /**
     * @var string
     */
    protected $source = Certificate::class;

    /**
     * @param string $code
     * @return Certificate|null
     */
    public function getCertificateByCode(string $code): ?Certificate
    {
        $query = $this->getQueryBuilder();

        return $query->where([
            'code' => $code
        ])->first();
    }
}
