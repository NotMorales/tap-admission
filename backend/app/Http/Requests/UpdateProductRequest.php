<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'code' => ['sometimes', 'string', 'max:20', Rule::unique('products', 'code')->ignore($productId)],
            'name' => ['sometimes', 'string', 'max:120'],
            'brand' => ['sometimes', 'string', 'max:120'],
            'price' => ['sometimes', 'integer', 'min:1', 'max:999'],
            'status' => ['sometimes', Rule::enum(ProductStatus::class)],
        ];
    }
}
