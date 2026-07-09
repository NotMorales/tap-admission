<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

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
            'meta' => $this->meta(),
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
            'meta' => $this->meta(),
        ], $status);
    }

    private function meta(): array
    {
        return [
            'timestamp' => now()->toISOString(),
            'request_id' => (string) Str::uuid(),
            'api_version' => 'v1',
        ];
    }
}
