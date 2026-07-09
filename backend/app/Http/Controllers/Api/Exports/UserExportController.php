<?php

namespace App\Http\Controllers\Api\Exports;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Pdf\UserPdf;
use App\Services\AuditLogService;
use App\Services\UserService;

class UserExportController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly AuditLogService $auditLogService,
    ) {}

    public function csv()
    {
        $this->auditLogService->record('USERS', 'EXPORT');

        return (new UsersExport)->downloadCsv();
    }

    public function pdf()
    {
        $users = $this->userService->allForExport();

        $this->auditLogService->record('USERS', 'EXPORT');

        return (new UserPdf($users))->download();
    }
}
