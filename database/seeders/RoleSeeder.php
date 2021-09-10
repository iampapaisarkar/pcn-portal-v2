<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
            'role' => 'Super Admin',
            'code' => 'sadmin',
            ],
            [
            'role' => 'State Office',
            'code' => 'state_office',
            ],
            [
            'role' => 'Registry',
            'code' => 'registry',
            ],
            [
            'role' => 'Pharmacy Practice',
            'code' => 'pharmacy_practice',
            ],
            [
            'role' => 'Inspection & Monitoring',
            'code' => 'inspection_monitoring',
            ],
            [
            'role' => 'Registration Licencing',
            'code' => 'registration_licencing',
            ],
            [
            'role' => 'Hospital & Pharmacy',
            'code' => 'hospital_pharmacy',
            ],
            [
            'role' => 'Community Pharmacy',
            'code' => 'community_pharmacy',
            ],
            [
            'role' => 'Distribution Premisis',
            'code' => 'distribution_premisis',
            ],
            [
            'role' => 'Manufacturing Premisis',
            'code' => 'manufacturing_premisis',
            ],
            [
            'role' => 'PPMV',
            'code' => 'ppmv',
            ]
        ];

        Role::insert($roles);
    }
}