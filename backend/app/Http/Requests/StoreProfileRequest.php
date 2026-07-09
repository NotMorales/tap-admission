<?php

namespace App\Http\Requests;

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
            'section_ids' => ['required', 'array', 'min:1'],
            'section_ids.*' => ['required', 'string'],
            'status' => ['required', Rule::enum(ProfileStatus::class)],
        ];
    }
}
