<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20', 'unique:products,code'],
            'name' => ['required', 'string', 'max:120'],
            'brand' => ['required', 'string', 'max:120'],
            'price' => ['required', 'integer', 'min:1', 'max:999'],
            'status' => ['required', Rule::enum(ProductStatus::class)],
        ];
    }
}
