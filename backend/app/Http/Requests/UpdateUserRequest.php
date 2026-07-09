<?php

namespace App\Http\Requests;

use App\Enums\UserStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'code' => ['sometimes', 'string', 'max:20', Rule::unique('users', 'code')->ignore($userId)],
            'name' => ['sometimes', 'string', 'max:120'],
            'email' => ['sometimes', 'email', 'max:150', Rule::unique('users', 'email')->ignore($userId)],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'string', 'max:255'],
            'profile_ids' => ['sometimes', 'array', 'min:1'],
            'profile_ids.*' => ['required', 'string'],
            'status' => ['sometimes', Rule::enum(UserStatus::class)],
        ];
    }
}
