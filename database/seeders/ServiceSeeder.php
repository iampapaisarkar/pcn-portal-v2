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
            'description' => 'Hospital Pharmacy',
            'updated_at' => now()
            ],
            [
            'description' => 'Community Pharmacy',
            'updated_at' => now()
            ],
            [
            'description' => 'Distribution Premises',
            'updated_at' => now()
            ],
            [
            'description' => 'Manufacturing Premises',
            'updated_at' => now()
            ],
            [
            'description' => 'PPMV',
            'updated_at' => now()
            ]
        ];

        Service::insert($services);
    }
}
