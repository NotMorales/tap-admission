<?php

namespace App\Http\Requests;

use App\Enums\PermissionAction;
use App\Enums\ProfileStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $profileId = $this->route('profile');

        return [
            'code' => ['sometimes', 'string', 'max:20', Rule::unique('profiles', 'code')->ignore($profileId)],
            'name' => ['sometimes', 'string', 'max:100'],
            'permissions' => ['sometimes', 'array', 'min:1'],
            'permissions.*.section_id' => ['required', 'string'],
            'permissions.*.actions' => ['required', 'array', 'min:1'],
            'permissions.*.actions.*' => ['required', Rule::enum(PermissionAction::class)],
            'status' => ['sometimes', Rule::enum(ProfileStatus::class)],
        ];
    }
}
