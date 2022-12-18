<?php

namespace App\Domain\ServiceContracts;

use App\Domain\Repositories\CertificateRepositoryContract;
use App\Http\Resources\CertificateResource;

/**
 * Interface CertificateServiceContract
 * @package App\Domain\ServiceContracts
 */
interface CertificateServiceContract
{
    /**
     * @return CertificateRepositoryContract
     */
    public function getRepository(): CertificateRepositoryContract;

    /**
     * @param array $params
     * @return CertificateResource
     */
    public function createCertificate(array $params = []): CertificateResource;

    /**
     * @param string $code
     * @return CertificateResource
     */
    public function getCertificateByCode(string $code): CertificateResource;

    /**
     * @param string $code
     * @return bool
     */
    public function checkCertificate(string $code): bool;
}
