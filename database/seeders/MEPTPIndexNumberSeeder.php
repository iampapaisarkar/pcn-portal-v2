<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MEPTPIndexNumber;

class MEPTPIndexNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $MEPTPIndexNumber = [
            [
            'arbitrary_1' => 'PCN',
            'arbitrary_2' => 'MT',
            'batch_year' => '3-2021',
            'state_code' => 'AB',
            'school_code' => 'SCH1',
            'tier' => 'T2',
            ]
        ];

        MEPTPIndexNumber::insert($MEPTPIndexNumber);
    }
}
