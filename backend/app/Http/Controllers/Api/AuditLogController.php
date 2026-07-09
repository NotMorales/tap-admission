<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AuditLogCollection;
use App\Http\Resources\AuditLogResource;
use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuditLogController extends BaseApiController
{
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

        return $this->resourceResponse(
            'Audit log retrieved successfully.',
            new AuditLogResource($log)
        );
    }
}
