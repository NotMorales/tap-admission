<?php

namespace App\Http\Resources;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $sections = Section::query()
            ->whereIn('_id', $this->section_ids ?? [])
            ->whereNull('deleted_at')
            ->orderBy('order')
            ->get();

        return [
            'id' => (string) $this->_id,
            'code' => $this->code,
            'name' => $this->name,
            'section_ids' => $this->section_ids,
            'sections' => SectionResource::collection($sections),
            'status' => $this->status,
            'created_at' => optional($this->created_at)->format('d/m/Y H:i'),
        ];
    }
}
