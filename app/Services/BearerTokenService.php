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
        $this->apiBase = env('API_BASE_URL', 'https://interview.civicplus.com/36f16afa-a628-44ca-bbcd-44559771bdcd/api');
        $this->clientId = env('API_CLIENT_ID', '36f16afa-a628-44ca-bbcd-44559771bdcd');
        $this->clientSecret = env('API_CLIENT_SECRET', 'bubtdyqxv0pv5zwf007payoofgsscwwjqcki8dekeccx');
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

        // Use Laravel's HTTP client to make a POST request
        // $response = Http::post($url, [
        //     'ClientId' => $this->clientId,
        //     'ClientSecret' => $this->clientSecret,
        // ]);
        $postData = [
            'ClientId' => $this->clientId,
            'ClientSecret' => $this->clientSecret,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);
        if ($response === false) {
            throw new \Exception(curl_error($ch));
        }

        $data = json_decode($response, true);
        return $data['access_token'] ?? null;
    }
}
