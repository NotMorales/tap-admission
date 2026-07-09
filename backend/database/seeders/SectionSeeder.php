<?php

namespace Database\Seeders;

use App\Enums\PermissionAction;
use App\Enums\SectionStatus;
use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'code' => 'SEC-000001',
                'name' => 'Dashboard',
                'route' => '/dashboard',
                'icon' => 'dashboard',
                'permissions' => [
                    PermissionAction::VIEW->value,
                ],
                'order' => 1,
                'status' => SectionStatus::ACTIVE->value,
            ],
            [
                'code' => 'SEC-000002',
                'name' => 'Usuarios',
                'route' => '/users',
                'icon' => 'group',
                'permissions' => [
                    PermissionAction::VIEW->value,
                    PermissionAction::CREATE->value,
                    PermissionAction::UPDATE->value,
                    PermissionAction::DELETE->value,
                    PermissionAction::EXPORT->value,
                ],
                'order' => 2,
                'status' => SectionStatus::ACTIVE->value,
            ],
            [
                'code' => 'SEC-000003',
                'name' => 'Productos',
                'route' => '/products',
                'icon' => 'inventory',
                'permissions' => [
                    PermissionAction::VIEW->value,
                    PermissionAction::CREATE->value,
                    PermissionAction::UPDATE->value,
                    PermissionAction::DELETE->value,
                    PermissionAction::EXPORT->value,
                ],
                'order' => 3,
                'status' => SectionStatus::ACTIVE->value,
            ],
            [
                'code' => 'SEC-000004',
                'name' => 'Perfiles',
                'route' => '/profiles',
                'icon' => 'admin_panel_settings',
                'permissions' => [
                    PermissionAction::VIEW->value,
                    PermissionAction::CREATE->value,
                    PermissionAction::UPDATE->value,
                    PermissionAction::DELETE->value,
                    PermissionAction::EXPORT->value,
                ],
                'order' => 4,
                'status' => SectionStatus::ACTIVE->value,
            ],
            [
                'code' => 'SEC-000005',
                'name' => 'Bitácora',
                'route' => '/audit-logs',
                'icon' => 'history',
                'permissions' => [
                    PermissionAction::VIEW->value,
                    PermissionAction::EXPORT->value,
                ],
                'order' => 5,
                'status' => SectionStatus::ACTIVE->value,
            ],
        ];

        foreach ($sections as $section) {
            Section::query()->updateOrCreate(
                ['code' => $section['code']],
                $section
            );
        }
    }
}
