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
            'description' => 'MEPTP Training Fees',
            'updated_at' => now()
            ],
            [
            'description' => 'Tiered PPMV Registration Fees',
            'updated_at' => now()
            ],
            [
            'description' => 'Tiered PPMV Renewal Fees',
            'updated_at' => now()
            ],
        ];

        Service::insert($services);
    }
}
