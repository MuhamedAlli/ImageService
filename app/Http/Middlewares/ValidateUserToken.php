<?php

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use App\Services\UserAuthService;
use Illuminate\Support\Facades\Log;

class ValidateUserToken
{
    protected $authService;

    public function __construct(UserAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Unauthorized - No token provided'], 401);
        }

        $userData = $this->authService->validateToken($token);
        if (!$userData) {
            return response()->json(['message' => 'Unauthorized - Invalid token'], 401);
        }
        return $next($request);
    }
}
