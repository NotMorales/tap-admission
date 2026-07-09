<?php

namespace App\Services;

use App\Enums\PermissionAction;
use App\Models\User;

class PermissionService
{
    public function __construct(
        private readonly AuthorizationService $authorizationService
    ) {}

    public function can(User $user, string $route, PermissionAction|string $action): bool
    {
        $actionValue = $action instanceof PermissionAction ? $action->value : strtoupper($action);

        return $this->authorizationService
            ->sections($user)
            ->contains(function ($section) use ($route, $actionValue) {
                return $section->route === $route
                    && in_array($actionValue, $section->allowed_actions ?? [], true);
            });
    }

    public function canBySectionName(User $user, string $sectionName, PermissionAction|string $action): bool
    {
        $actionValue = $action instanceof PermissionAction ? $action->value : strtoupper($action);

        return $this->authorizationService
            ->sections($user)
            ->contains(function ($section) use ($sectionName, $actionValue) {
                return strtolower($section->name) === strtolower($sectionName)
                    && in_array($actionValue, $section->permissions ?? [], true);
            });
    }
}
