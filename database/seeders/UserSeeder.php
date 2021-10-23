<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $users = [
            [
            'firstname' => 'Super',
            'lastname' => 'Admin',
            'phone' => '+919002090020',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'state' => null,
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'State',
            'lastname' => 'Offcie',
            'phone' => '+919002090020',
            'email' => 'state@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => 2,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'firstname' => 'Registry',
            'lastname' => 'Registry',
            'phone' => '+919002090020',
            'email' => 'registry@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'firstname' => 'Pharmacy',
            'lastname' => 'Practice',
            'phone' => '+919002090020',
            'email' => 'pharmacy@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Inspection',
            'lastname' => 'Monitoring',
            'phone' => '+919002090020',
            'email' => 'inspection@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Registration',
            'lastname' => 'Licencing',
            'phone' => '+919002090020',
            'email' => 'licence@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],



            [
            'firstname' => 'Hospital',
            'lastname' => 'Pharmacy',
            'phone' => '+919002090020',
            'email' => 'hospital@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Community',
            'lastname' => 'Pharmacy',
            'phone' => '+919002090020',
            'email' => 'community@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Distribution',
            'lastname' => 'premises',
            'phone' => '+919002090020',
            'email' => 'distribution@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Manufacturing',
            'lastname' => 'premises',
            'phone' => '+919002090020',
            'email' => 'iampapaisarkar@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'PPMV',
            'lastname' => 'PPMV',
            'phone' => '+919002090020',
            'email' => 'ppmv@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
        ];

        User::insert($users);
    }
}
