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
            'description' => 'MEPTP Registration Fee',
            'amount' => 50,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 1,
            'description' => 'MEPTP Traning Handbook',
            'amount' => 150,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 1,
            'description' => 'Training School Fees',
            'amount' => 50,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 2,
            'description' => 'MEPTP Registration Fee',
            'amount' => 50,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 2,
            'description' => 'MEPTP Traning Handbook',
            'amount' => 150,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 2,
            'description' => 'Training School Fees',
            'amount' => 50,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 3,
            'description' => 'MEPTP Registration Fee',
            'amount' => 50,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 3,
            'description' => 'MEPTP Traning Handbook',
            'amount' => 150,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 3,
            'description' => 'Training School Fees',
            'amount' => 50,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 4,
            'description' => 'MEPTP Registration Fee',
            'amount' => 50,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 4,
            'description' => 'MEPTP Traning Handbook',
            'amount' => 150,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 4,
            'description' => 'Training School Fees',
            'amount' => 50,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 5,
            'description' => 'MEPTP Registration Fee',
            'amount' => 50,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 5,
            'description' => 'MEPTP Traning Handbook',
            'amount' => 150,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 5,
            'description' => 'Training School Fees',
            'amount' => 50,
            'status' => false,
            'updated_at' => now()
            ],
           
        ];

        ServiceFeeMeta::insert($services);
    }
}
