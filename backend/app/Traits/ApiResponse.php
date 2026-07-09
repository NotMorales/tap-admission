<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse(
        string $message = 'Operation completed successfully.',
        mixed $data = null,
        int $status = 200,
        array $extra = []
    ): JsonResponse {
        return response()->json(array_merge([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null,
            'meta' => [
                'timestamp' => now()->toISOString(),
            ],
        ], $extra), $status);
    }

    protected function errorResponse(
        string $message = 'An error occurred.',
        mixed $errors = null,
        int $status = 400
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null,
            'errors' => $errors,
            'meta' => [
                'timestamp' => now()->toISOString(),
            ],
        ], $status);
    }
}
