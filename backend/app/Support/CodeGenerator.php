<?php

namespace App\Support;

class CodeGenerator
{
    public static function generate(string $model, string $prefix, string $field = 'code'): string
    {
        $last = $model::query()
            ->orderBy($field, 'desc')
            ->first();

        if (! $last || ! isset($last->{$field})) {
            return $prefix.'-000001';
        }

        $number = (int) str_replace($prefix.'-', '', $last->{$field});

        return $prefix.'-'.str_pad($number + 1, 6, '0', STR_PAD_LEFT);
    }
}
