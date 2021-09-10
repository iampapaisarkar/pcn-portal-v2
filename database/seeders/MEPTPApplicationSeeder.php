<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MEPTPApplication;

class MEPTPApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $MEPTPApplication = [
            [
            'vendor_id' => 5,
            'birth_certificate' => 'Test',
            'educational_certificate' => 'Test',
            'academic_certificate' => 'Test',
            'shop_name' => 'Test',
            'shop_phone' => '9002090020',
            'shop_email' => 'test@test.test',
            'shop_address' => 'Test',
            'city' => 'Test',
            'state' => 2,
            'lga' => 6,
            'is_registered' => false,
            'traing_centre' => 1,
            'batch_id' => 1,
            'tier_id' => 2,
            'index_number_id' => 1000,
            'status' => 'send_to_state_office',
            'payment' => true,
            'created_at' => now(),
            ]
        ];

        MEPTPApplication::insert($MEPTPApplication);
    }
}
