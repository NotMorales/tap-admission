<?php

namespace App\Http\Requests;

use App\Enums\PermissionAction;
use App\Enums\SectionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20', 'unique:sections,code'],
            'name' => ['required', 'string', 'max:100'],
            'route' => ['required', 'string', 'max:100', 'unique:sections,route'],
            'icon' => ['nullable', 'string', 'max:50'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*' => ['required', Rule::enum(PermissionAction::class)],
            'order' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', Rule::enum(SectionStatus::class)],
        ];
    }
}
