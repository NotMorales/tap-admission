<?php

namespace App\Http\Requests;

use App\Enums\PermissionAction;
use App\Enums\ProfileStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20', 'unique:profiles,code'],
            'name' => ['required', 'string', 'max:100'],
            'permissions' => ['required', 'array', 'min:1'],
            'permissions.*.section_id' => ['required', 'string'],
            'permissions.*.actions' => ['required', 'array', 'min:1'],
            'permissions.*.actions.*' => ['required', Rule::enum(PermissionAction::class)],
            'status' => ['required', Rule::enum(ProfileStatus::class)],
        ];
    }
}
