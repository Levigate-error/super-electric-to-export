<?php

namespace App\Http\Controllers\Api;

use App\Domain\ServiceContracts\CertificateServiceContract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CertificateRequest;

class CertificateController extends Controller
{

    protected $service;

    public function __construct(CertificateServiceContract $service)
    {
        $this->service = $service;
    }

    public function register(CertificateRequest $request)
    {
        $this->service->registerUser($request->code);

        return response()->json(['message' => __('certificates.registered')]);
    }
}
