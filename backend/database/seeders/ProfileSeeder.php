<?php

namespace Database\Seeders;

use App\Enums\PermissionAction;
use App\Enums\ProfileStatus;
use App\Models\Profile;
use App\Models\Section;

class ProfileSeeder extends BaseSeeder
{
    public function run(): void
    {
        $dashboard = Section::where('code', 'SEC-000001')->first();
        $users = Section::where('code', 'SEC-000002')->first();
        $products = Section::where('code', 'SEC-000003')->first();
        $profiles = Section::where('code', 'SEC-000004')->first();
        $audit = Section::where('code', 'SEC-000005')->first();

        $this->seed(
            Profile::class,
            'code',
            [
                [
                    'code' => 'PRF-000001',
                    'name' => 'Administrador',
                    'permissions' => [
                        [
                            'section_id' => (string) $dashboard->_id,
                            'actions' => [
                                PermissionAction::VIEW->value,
                            ],
                        ],
                        [
                            'section_id' => (string) $users->_id,
                            'actions' => [
                                PermissionAction::VIEW->value,
                                PermissionAction::CREATE->value,
                                PermissionAction::UPDATE->value,
                                PermissionAction::DELETE->value,
                                PermissionAction::EXPORT->value,
                            ],
                        ],
                        [
                            'section_id' => (string) $products->_id,
                            'actions' => [
                                PermissionAction::VIEW->value,
                                PermissionAction::CREATE->value,
                                PermissionAction::UPDATE->value,
                                PermissionAction::DELETE->value,
                                PermissionAction::EXPORT->value,
                            ],
                        ],
                        [
                            'section_id' => (string) $profiles->_id,
                            'actions' => [
                                PermissionAction::VIEW->value,
                                PermissionAction::CREATE->value,
                                PermissionAction::UPDATE->value,
                                PermissionAction::DELETE->value,
                                PermissionAction::EXPORT->value,
                            ],
                        ],
                        [
                            'section_id' => (string) $audit->_id,
                            'actions' => [
                                PermissionAction::VIEW->value,
                                PermissionAction::EXPORT->value,
                            ],
                        ],
                    ],
                    'status' => ProfileStatus::ACTIVE->value,
                ],
                [
                    'code' => 'PRF-000002',
                    'name' => 'Supervisor',
                    'permissions' => [
                        [
                            'section_id' => (string) $dashboard->_id,
                            'actions' => [
                                PermissionAction::VIEW->value,
                            ],
                        ],
                        [
                            'section_id' => (string) $products->_id,
                            'actions' => [
                                PermissionAction::VIEW->value,
                                PermissionAction::UPDATE->value,
                            ],
                        ],
                    ],
                    'status' => ProfileStatus::ACTIVE->value,
                ],
                [
                    'code' => 'PRF-000003',
                    'name' => 'Consulta',
                    'permissions' => [
                        [
                            'section_id' => (string) $dashboard->_id,
                            'actions' => [
                                PermissionAction::VIEW->value,
                            ],
                        ],
                        [
                            'section_id' => (string) $products->_id,
                            'actions' => [
                                PermissionAction::VIEW->value,
                            ],
                        ],
                    ],
                    'status' => ProfileStatus::ACTIVE->value,
                ],
            ]
        );
    }
}
