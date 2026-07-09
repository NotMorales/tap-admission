<?php

namespace App\Logging;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityLogger
{
    public function info(string $module, string $action, array $payload = []): void
    {
        Log::info('Activity log', [
            'module' => $module,
            'action' => $action,
            'user_id' => Auth::id(),
            'ip' => request()?->ip(),
            'user_agent' => request()?->userAgent(),
            'payload' => $payload,
            'created_at' => now()->toISOString(),
        ]);
    }
}
