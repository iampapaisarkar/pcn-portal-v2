<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MEPTPResult;

class MEPTPResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $MEPTPResult = [
            [
            'application_id' => 1,
            'vendor_id' => 5,
            'status' => 'pass',
            'result' => 'pass',
            ]
        ];

        MEPTPResult::insert($MEPTPResult);
    }
}
