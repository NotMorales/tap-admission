<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Services\AuditLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordRecoveryController extends BaseApiController
{
    public function __construct(
        private readonly AuditLogService $auditLogService
    ) {}

    public function recover(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $data['email'])
            ->whereNull('deleted_at')
            ->first();

        if (! $user) {
            return $this->errorResponse(
                message: 'User not found.',
                errors: null,
                status: 404,
                code: 'USER_NOT_FOUND'
            );
        }

        $temporaryPassword = 'Tap-' . Str::upper(Str::random(8));

        $user->password = Hash::make($temporaryPassword);
        $user->save();

        $this->auditLogService->record(
            module: 'AUTH',
            action: 'PASSWORD_RECOVERY',
            model: $user,
            oldData: [],
            newData: [
                'email' => $user->email,
                'temporary_password_generated' => true,
            ]
        );

        return $this->resourceResponse(
            'Temporary password generated successfully.',
            [
                'email' => $user->email,
                'temporary_password' => $temporaryPassword,
                'note' => 'In production this password should be sent by email.',
            ]
        );
    }
}
