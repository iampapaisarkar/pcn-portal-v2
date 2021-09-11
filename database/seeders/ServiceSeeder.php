<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
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
            'description' => 'Hospital Pharmacy Registration Fees',
            'updated_at' => now()
            ],
            [
            'description' => 'Hospital Pharmacy Licence Renewal Fees',
            'updated_at' => now()
            ],
            [
            'description' => 'PPMV Location Approval Fees',
            'updated_at' => now()
            ],
            [
            'description' => 'PPMV Registration and Licencing Fees',
            'updated_at' => now()
            ],
            [
            'description' => 'PPMV Licence Renewal Fees',
            'updated_at' => now()
            ]
        ];

        Service::insert($services);
    }
}
