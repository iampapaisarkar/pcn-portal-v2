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
            'firstname' => 'Public',
            'lastname' => 'Vendor 1',
            'phone' => '+919002090020',
            'email' => 'iampapaisarkar@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor 2',
            'phone' => '+919002090020',
            'email' => 'vendor2@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor 3',
            'phone' => '+919002090020',
            'email' => 'vendor3@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor 4',
            'phone' => '+919002090020',
            'email' => 'vendor4@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor 5',
            'phone' => '+919002090020',
            'email' => 'vendor5@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor 6',
            'phone' => '+919002090020',
            'email' => 'vendor6@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor 7',
            'phone' => '+919002090020',
            'email' => 'vendor7@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor 8',
            'phone' => '+919002090020',
            'email' => 'vendor8@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor 9',
            'phone' => '+919002090020',
            'email' => 'vendor9@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor 10',
            'phone' => '+919002090020',
            'email' => 'vendor10@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'Public',
            'lastname' => 'Vendor 11',
            'phone' => '+919002090020',
            'email' => 'vendor11@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => null,
            'created_at' => now(),
            'updated_at' => now()
            ],
            [
            'firstname' => 'State',
            'lastname' => 'Offcie 2',
            'phone' => '+919002090020',
            'email' => 'state2@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'state' => 3,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'firstname' => 'Pharmacy',
            'lastname' => 'Practice 2',
            'phone' => '+919002090020',
            'email' => 'pharmacy2@test.com',
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
