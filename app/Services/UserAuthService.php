<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class UserAuthService
{
    protected $baseUrl;
    public function __construct()
    {
        $this->baseUrl = env('USER_SERVICE_URL');
    }

    public function validateToken($token)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->post("{$this->baseUrl}/api/auth/validate-token");

            if (!$response->successful() || !$response->json('valid')) {
                return null;
            }

            return $response;
        } catch (Exception $e) {
            return false;
        }
    }
}
