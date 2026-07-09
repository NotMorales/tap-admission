<?php

namespace App\Http\Middleware;

use App\Services\PermissionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasPermission
{
    public function __construct(
        private readonly PermissionService $permissionService
    ) {}

    public function handle(Request $request, Closure $next, string $route, string $action): Response
    {
        $user = Auth::guard('api')->user();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
                'code' => 'UNAUTHENTICATED',
                'data' => null,
                'errors' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                ],
            ], 401);
        }

        if (! $this->permissionService->can($user, $route, $action)) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to perform this action.',
                'code' => 'FORBIDDEN',
                'data' => null,
                'errors' => null,
                'meta' => [
                    'timestamp' => now()->toISOString(),
                ],
            ], 403);
        }

        return $next($request);
    }
}
