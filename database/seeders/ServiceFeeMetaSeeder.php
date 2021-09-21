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
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 1,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 1,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 2,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 2,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 2,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 3,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 3,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 3,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 4,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 4,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 4,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 5,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 5,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 5,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 6,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 6,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 6,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 7,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 7,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 7,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 8,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 8,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 8,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 9,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 9,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 9,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 10,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 10,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 10,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 11,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 11,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 11,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 12,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 12,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 12,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 13,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 13,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 13,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],

            [
            'service_id' => 14,
            'description' => 'Registration Fee',
            'amount' => 5000,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 14,
            'description' => 'Traning Handbook',
            'amount' => 2500,
            'status' => true,
            'updated_at' => now()
            ],
            [
            'service_id' => 14,
            'description' => 'Training Fees',
            'amount' => 3000,
            'status' => false,
            'updated_at' => now()
            ],
           
        ];

        ServiceFeeMeta::insert($services);
    }
}
