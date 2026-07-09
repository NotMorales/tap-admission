<?php

namespace App\Models;

use App\Enums\UserStatus;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseModel implements AuthenticatableContract, JWTSubject
{
    use Authenticatable;

    public const COLLECTION = 'users';

    protected $collection = self::COLLECTION;

    protected $fillable = [
        'code',
        'name',
        'email',
        'password',
        'phone',
        'photo',
        'profile_ids',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'profile_ids' => 'array',
        'status' => UserStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
