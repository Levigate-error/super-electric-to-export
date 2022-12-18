<?php

namespace App\Services;

use App\Http\Resources\CertificateResource;
use App\Services\BaseService;
use App\Domain\ServiceContracts\CertificateServiceContract;
use App\Domain\Repositories\CertificateRepositoryContract;
use Illuminate\Support\Facades\Auth;

class CertificateService extends BaseService implements CertificateServiceContract
{
    /**
     * @var CertificateRepositoryContract
     */
    private $repository;

    /**
     * CertificateService constructor.
     * @param CertificateRepositoryContract $repository
     */
    public function __construct(CertificateRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return CertificateRepositoryContract
     */
    public function getRepository(): CertificateRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @param array $params
     * @return CertificateResource
     */
    public function createCertificate(array $params = []): CertificateResource
    {
        $certificate = $this->repository->getSource()::create($params);

        return CertificateResource::make($certificate);
    }

    /**
     * @param string $code
     * @return CertificateResource
     */
    public function getCertificateByCode(string $code): CertificateResource
    {
        $certificate = $this->repository->getCertificateByCode($code);

        return CertificateResource::make($certificate);
    }

    /**
     * @param string $code
     * @return bool
     */
    public function checkCertificate(string $code): bool
    {
        $certificate = $this->getCertificateByCode($code);

        if ($certificate->resource === null) {
            return false;
        }

        if ($certificate->resource->active === false) {
            return false;
        }

        return true;
    }

    /**
     * @param string $code
     * @return void
     */
    public function registerUser(string $code)
    {
        $certificate = $this->getCertificateByCode($code)->resource;

        if (is_null($certificate) || !$certificate->active) {
            abort(404, __('certificates.not-found'));
        }
        /** @var \App\Models\User */
        $user = Auth::user();
        $user->certificates()->attach($certificate);
        $certificate->active = false;
        $certificate->save();
    }
}