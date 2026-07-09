<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

abstract class BaseApiController extends Controller
{
    use ApiResponse;

    protected function resourceResponse(
        string $message,
        mixed $resource,
        int $status = 200
    ): JsonResponse {
        return $this->successResponse(
            message: $message,
            data: $resource,
            status: $status
        );
    }

    protected function deletedResponse(string $message): JsonResponse
    {
        return $this->successResponse(
            message: $message,
            data: null
        );
    }
}
