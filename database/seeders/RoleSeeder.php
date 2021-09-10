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
            'role' => 'Pharmacy Practice',
            'code' => 'pharmacy_practice',
            ],
            [
            'role' => 'Registration Licencing',
            'code' => 'registration_licencing',
            ],
            [
            'role' => 'Vendor',
            'code' => 'vendor',
            ],
        ];

        Role::insert($roles);
    }
}