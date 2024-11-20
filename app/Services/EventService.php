<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;

class EventService
{
    private $apiBase;
    private $tokenService;

    public function __construct(BearerTokenService $tokenService)
    {
        $this->apiBase = env('API_BASE_URL');
        $this->tokenService = $tokenService;
    }

    public function getEvents()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->tokenService->getBearerToken(),
            ])->get("{$this->apiBase}/events");

            if ($response->failed()) {
                throw new \Exception('Failed to fetch events.');
            }
            return $response->json();
        } catch (Exception $e) {
            $this->handleApiError($e);
        }
    }

    private function handleApiError(Exception $exception)
    {
        // Log the error for debugging purposes
        Log::error('API Error', [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ]);

        // Throw a user-friendly exception
        throw new \App\Exceptions\ApiException(
            $exception->getMessage(),
            $exception->getCode() ?: 500
        );
    }

    public function createEvent(array $data)
    {
        //dd($data);
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->tokenService->getBearerToken(),
            ])->post("{$this->apiBase}/events", $data);

            if ($response->failed()) {
                throw new \Exception('Failed to create event.');
            }

            return $response->json();
        } catch (Exception $e) {
            $this->handleApiError($e);
        }
    }

    public function showEvent($id)
    {
        //dd($data);
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->tokenService->getBearerToken(),
            ])->get("{$this->apiBase}/events/" . $id);

            if ($response->failed()) {
                throw new \Exception('Failed to show event.');
            }

            return $response->json();
        } catch (Exception $e) {
            $this->handleApiError($e);
        }
    }
}
