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
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return response()->json(array_merge($response, $extra), $status);
    }

    protected function errorResponse(
        string $message = 'An error occurred.',
        mixed $errors = null,
        int $status = 400
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
