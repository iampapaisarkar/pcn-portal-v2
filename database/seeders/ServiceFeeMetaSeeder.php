<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceFeeMeta;

class ServiceFeeMetaSeeder extends Seeder
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
            'description' => 'MEPTP Training Fees 1',
            'amount' => 50,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 1,
            'description' => 'MEPTP Training Fees 2',
            'amount' => 150,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 1,
            'description' => 'MEPTP Training Fees 3',
            'amount' => 50,
            'status' => false,
            'updated_at' => now()
            ],
            [
            'service_id' => 2,
            'description' => 'PPMV Registration Fees 1',
            'amount' => 50,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 2,
            'description' => 'PPMV Registration Fees 2',
            'amount' => 150,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 2,
            'description' => 'PPMV Registration Fees 3',
            'amount' => 50,
            'status' => false,
            'updated_at' => now()
            ],
            [
            'service_id' => 3,
            'description' => 'PPMV Renewal Fees 1',
            'amount' => 50,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 3,
            'description' => 'PPMV Renewal Fees 2',
            'amount' => 150,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 3,
            'description' => 'PPMV Renewal Fees 3',
            'amount' => 50,
            'status' => false,
            'updated_at' => now()
            ],
        ];

        ServiceFeeMeta::insert($services);
    }
}
