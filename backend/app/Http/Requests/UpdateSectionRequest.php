<?php

namespace App\Http\Requests;

use App\Enums\PermissionAction;
use App\Enums\SectionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sectionId = $this->route('section');

        return [
            'code' => ['sometimes', 'string', 'max:20', Rule::unique('sections', 'code')->ignore($sectionId)],
            'name' => ['sometimes', 'string', 'max:100'],
            'route' => ['sometimes', 'string', 'max:100', Rule::unique('sections', 'route')->ignore($sectionId)],
            'icon' => ['nullable', 'string', 'max:50'],
            'permissions' => ['sometimes', 'array', 'min:1'],
            'permissions.*' => ['required', Rule::enum(PermissionAction::class)],
            'order' => ['nullable', 'integer', 'min:1'],
            'status' => ['sometimes', Rule::enum(SectionStatus::class)],
        ];
    }
}
