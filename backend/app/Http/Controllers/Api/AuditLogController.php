<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuditLogCollection;
use App\Http\Resources\AuditLogResource;
use App\Services\AuditLogService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AuditLogService $auditLogService
    ) {}

    public function index(Request $request): AuditLogCollection
    {
        $logs = $this->auditLogService->paginate(
            filters: $request->only(['search', 'status', 'sort', 'direction']),
            perPage: (int) $request->get('per_page', 10)
        );

        return new AuditLogCollection($logs);
    }

    public function show(string $id): JsonResponse
    {
        $log = $this->auditLogService->find($id);

        return $this->successResponse(
            message: 'Audit log retrieved successfully.',
            data: new AuditLogResource($log)
        );
    }
}
