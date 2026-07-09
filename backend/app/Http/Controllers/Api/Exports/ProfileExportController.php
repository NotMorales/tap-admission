<?php

namespace App\Http\Controllers\Api\Exports;

use App\Exports\ProfilesExport;
use App\Http\Controllers\Controller;
use App\Pdf\ProfilePdf;
use App\Services\AuditLogService;
use App\Services\ProfileService;

class ProfileExportController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
        private readonly AuditLogService $auditLogService,
    ) {}

    public function csv()
    {
        $this->auditLogService->record('PROFILES', 'EXPORT');

        return (new ProfilesExport())->downloadCsv();
    }

    public function pdf()
    {
        $profiles = $this->profileService->allForExport();

        $this->auditLogService->record('PROFILES', 'EXPORT');

        return (new ProfilePdf($profiles))->download();
    }
}
