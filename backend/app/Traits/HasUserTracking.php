<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasUserTracking
{
    protected static function bootHasUserTracking(): void
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = (string) Auth::id();
                $model->updated_by = (string) Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = (string) Auth::id();
            }
        });

        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->deleted_by = (string) Auth::id();
                $model->saveQuietly();
            }
        });
    }
}
