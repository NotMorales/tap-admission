<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AuthProfileResource;
use App\Http\Resources\AuthSectionResource;
use App\Http\Resources\AuthUserResource;
use App\Services\AuditLogService;
use App\Services\AuthorizationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseApiController
{
    public function __construct(
        private readonly AuthorizationService $authorizationService,
        private readonly AuditLogService $auditLogService
    ) {}

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return $this->errorResponse('Invalid credentials.', null, 401, 'INVALID_CREDENTIALS');
        }

        $user = Auth::guard('api')->user();
        $context = $this->authorizationService->context($user);

        $this->auditLogService->record(
            module: 'AUTH',
            action: 'LOGIN',
            model: $user,
            oldData: [],
            newData: [
                'email' => $user->email,
                'login_success' => true,
            ]
        );

        return $this->resourceResponse('Login successful.', [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => new AuthUserResource($context['user']),
            'profiles' => AuthProfileResource::collection($context['profiles']),
            'sections' => AuthSectionResource::collection($context['sections']),
        ]);
    }

    public function me(): JsonResponse
    {
        $user = Auth::guard('api')->user();
        $context = $this->authorizationService->context($user);

        return $this->resourceResponse('Authenticated user retrieved successfully.', [
            'user' => new AuthUserResource($context['user']),
            'profiles' => AuthProfileResource::collection($context['profiles']),
            'sections' => AuthSectionResource::collection($context['sections']),
        ]);
    }

    public function logout(): JsonResponse
    {
        $user = Auth::guard('api')->user();

        $this->auditLogService->record(
            module: 'AUTH',
            action: 'LOGOUT',
            model: $user,
            oldData: [],
            newData: [
                'email' => $user?->email,
                'logout_success' => true,
            ]
        );

        Auth::guard('api')->logout();

        return $this->deletedResponse('Logout successful.');
    }
}
