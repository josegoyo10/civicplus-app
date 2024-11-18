<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\BearerTokenService;

class InjectBearerToken
{
    private $tokenService;

    public function __construct(BearerTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Retrieve the Bearer token
            $token = $this->tokenService->getBearerToken();

            if (!$token) {
                throw new \Exception('Bearer token is unavailable.');
            }

            // Set the Authorization header
            $request->headers->set('Authorization', "Bearer $token");
        } catch (\Exception $e) {
            abort(500, 'Failed to inject Bearer token: ' . $e->getMessage());
        }

        return $next($request);
    }
}
