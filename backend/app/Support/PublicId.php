<?php

namespace App\Support;

use Illuminate\Support\Str;

class PublicId
{
    public static function generate(string $prefix): string
    {
        return strtoupper($prefix) . '-' . now()->format('Ymd') . '-' . Str::upper(Str::random(8));
    }
}
