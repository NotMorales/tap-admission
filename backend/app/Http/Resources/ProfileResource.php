<?php

namespace App\Http\Resources;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $permissions = collect($this->permissions ?? []);

        $sectionIds = $permissions
            ->pluck('section_id')
            ->unique()
            ->values()
            ->toArray();

        $sections = Section::query()
            ->whereIn('_id', $sectionIds)
            ->whereNull('deleted_at')
            ->orderBy('order')
            ->get()
            ->map(function ($section) use ($permissions) {
                $permission = $permissions
                    ->firstWhere('section_id', (string) $section->_id);

                return [
                    'id' => (string) $section->_id,
                    'code' => $section->code,
                    'name' => $section->name,
                    'route' => $section->route,
                    'icon' => $section->icon,
                    'actions' => $permission['actions'] ?? [],
                ];
            });

        return [
            'id' => (string) $this->_id,
            'code' => $this->code,
            'name' => $this->name,
            'permissions' => $this->permissions ?? [],
            'sections' => $sections,
            'status' => $this->status,
            'created_at' => optional($this->created_at)->format('d/m/Y H:i'),
        ];
    }
}
