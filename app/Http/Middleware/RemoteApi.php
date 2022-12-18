<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\IpUtils;

/**
 * Class RemoteApi
 * @package App\Http\Middleware
 */
class RemoteApi
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->checkAuthorized($request) === false) {
            return response()->json('Unauthorized', 401);
        }

        return $next($request);
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function checkAuthorized(Request $request): bool
    {
        if (empty($request->bearerToken()) === true || $request->bearerToken() !== config('remote-api.token')) {
            return false;
        }

        $restrictedIps = explode(',', config('remote-api.restricted_ips'));
        if (IpUtils::checkIp($request->getClientIp(), $restrictedIps) === false) {
            return false;
        }

        return true;
    }
}
