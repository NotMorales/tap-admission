<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Repositories\AuditLogRepository;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class AuditLogService extends BaseService
{
    public function __construct(
        private readonly AuditLogRepository $auditLogRepository
    ) {}

    protected function repository(): BaseRepository
    {
        return $this->auditLogRepository;
    }

    public function create(array $data): BaseModel
    {
        return $this->repository()->create($data);
    }

    public function record(
        string $module,
        string $action,
        ?BaseModel $model = null,
        array $oldData = [],
        array $newData = []
    ): BaseModel {
        $user = Auth::guard('api')->user();

        return $this->create([
            'module' => $module,
            'action' => $action,
            'record_id' => $model ? (string) $model->_id : null,
            'record_code' => $model?->code,
            'old_data' => $oldData,
            'new_data' => $newData,
            'performed_by' => $user ? [
                'user_id' => (string) $user->_id,
                'name' => $user->name,
                'email' => $user->email,
            ] : null,
            'request' => [
                'ip' => request()?->ip(),
                'user_agent' => request()?->userAgent(),
                'method' => request()?->method(),
                'url' => request()?->fullUrl(),
            ],
        ]);
    }

    protected function notFoundMessage(): string
    {
        return 'Audit log not found.';
    }
}
