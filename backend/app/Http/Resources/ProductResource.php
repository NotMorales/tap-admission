<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->_id,
            'code' => $this->code,
            'name' => $this->name,
            'brand' => $this->brand,
            'price' => $this->price,
            'status' => $this->status,
            'created_at' => optional($this->created_at)->format('d/m/Y H:i'),
        ];
    }
}
