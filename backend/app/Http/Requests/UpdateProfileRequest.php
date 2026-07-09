<?php

namespace App\Http\Requests;

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
            'section_ids' => ['sometimes', 'array', 'min:1'],
            'section_ids.*' => ['required', 'string'],
            'status' => ['sometimes', Rule::enum(ProfileStatus::class)],
        ];
    }
}
