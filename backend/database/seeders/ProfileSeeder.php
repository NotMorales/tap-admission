<?php

namespace Database\Seeders;

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
                    'section_ids' => [
                        (string)$dashboard->_id,
                        (string)$users->_id,
                        (string)$products->_id,
                        (string)$profiles->_id,
                        (string)$audit->_id,
                    ],
                    'status' => ProfileStatus::ACTIVE->value,
                ],
                [
                    'code' => 'PRF-000002',
                    'name' => 'Supervisor',
                    'section_ids' => [
                        (string)$dashboard->_id,
                        (string)$products->_id,
                    ],
                    'status' => ProfileStatus::ACTIVE->value,
                ],
            ]
        );
    }
}
