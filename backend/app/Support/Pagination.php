<?php

namespace App\Support;

use Illuminate\Http\Request;

class Pagination
{
    public static function fromRequest(Request $request): array
    {
        return [
            'page' => (int) $request->get('page', 1),
            'per_page' => min((int) $request->get('per_page', 10), 100),
            'sort' => $request->get('sort', 'created_at'),
            'direction' => $request->get('direction', 'desc'),
            'search' => $request->get('search'),
            'status' => $request->get('status'),
        ];
    }
}
