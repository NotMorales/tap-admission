<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->_id,
            'module' => $this->module,
            'action' => $this->action,
            'record_id' => $this->record_id,
            'record_code' => $this->record_code,
            'old_data' => $this->old_data,
            'new_data' => $this->new_data,
            'performed_by' => $this->performed_by,
            'request' => $this->request,
            'created_at' => optional($this->created_at)->format('d/m/Y H:i'),
        ];
    }
}
