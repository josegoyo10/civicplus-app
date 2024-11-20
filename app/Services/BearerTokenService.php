<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class BearerTokenService
{
    private $apiBase;
    private $clientId;
    private $clientSecret;

    /**
     * BearerTokenService constructor
     * Initialize API details.
     */
    public function __construct()
    {
        $this->apiBase = env('API_BASE_URL');
        $this->clientId = env('API_CLIENT_ID');
        $this->clientSecret = env('API_CLIENT_SECRET');
        //dd($this->apiBase);
    }

    /**
     * Get the Bearer token, using cache to minimize API calls.
     *
     * @return string|null
     * @throws \Exception
     */
    public function getBearerToken(): ?string
    {
        return Cache::remember('api_bearer_token', 55, function () {
            return $this->fetchBearerToken();
        });
    }

    /**
     * Fetch a new Bearer token from the API.
     *
     * @return string|null
     * @throws \Exception
     */
    private function fetchBearerToken(): ?string
    {
        $url = "{$this->apiBase}/Auth";
        $response = Http::post($url, [
            'ClientId' => $this->clientId,
            'ClientSecret' => $this->clientSecret,
        ]);
        $data = json_decode($response, true);
        return $data['access_token'] ?? null;
    }
}
