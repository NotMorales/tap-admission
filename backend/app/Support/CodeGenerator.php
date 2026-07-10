<?php

namespace App\Support;

class CodeGenerator
{
    public static function generate(string $model, string $prefix, string $field = 'code'): string
    {
        $pattern = '/^' . preg_quote($prefix, '/') . '-[0-9]+$/';

        $codes = $model::query()
            ->withTrashed()
            ->where($field, 'regex', $pattern)
            ->pluck($field)
            ->toArray();

        $max = 0;

        foreach ($codes as $code) {
            $number = (int) str_replace($prefix . '-', '', $code);

            if ($number > $max) {
                $max = $number;
            }
        }

        return $prefix . '-' . str_pad($max + 1, 6, '0', STR_PAD_LEFT);
    }
}
