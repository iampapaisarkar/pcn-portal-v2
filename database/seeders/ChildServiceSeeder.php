<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChildService;

class ChildServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            [
            'service_id' => 1,
            'description' => 'Hospital Pharmacy Registration Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 1,
            'description' => 'Hospital Pharmacy Licence Renewal Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 2,
            'description' => 'Community Pharmacy Location Approval Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 2,
            'description' => 'Community Pharmacy Registration and Licencing Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 2,
            'description' => 'Community Pharmacy Licence Renewal Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 3,
            'description' => 'Distribution Premises Location Approval Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 3,
            'description' => 'Distribution Premises Registration and Licencing Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 3,
            'description' => 'Distribution Premises Licence Renewal Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 4,
            'description' => 'Manufacturing Premises Location Approval Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 4,
            'description' => 'Manufacturing Premises Registration and Licencing Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 4,
            'description' => 'Manufacturing Premises Licence Renewal Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 5,
            'description' => 'PPMV Location Approval Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 5,
            'description' => 'PPMV Registration and Licencing Fees',
            'updated_at' => now()
            ],
            [
            'service_id' => 5,
            'description' => 'PPMV Licence Renewal Fees',
            'updated_at' => now()
            ]
        ];

        ChildService::insert($services);
    }
}
