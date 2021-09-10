<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $School = [
            [
            'name' => 'School 1',
            'code' => 'SCH1',
            'state' => 2,
            'status' => true
            ],
            [
            'name' => 'School 2',
            'code' => 'SCH2',
            'state' => 2,
            'status' => true
            ],
            [
            'name' => 'School 3',
            'code' => 'SCH3',
            'state' => 2,
            'status' => true
            ],
            [
            'name' => 'School 1',
            'code' => 'SCH4',
            'state' => 3,
            'status' => true
            ],
            [
            'name' => 'School 2',
            'code' => 'SCH5',
            'state' => 3,
            'status' => true
            ],
            [
            'name' => 'School 3',
            'code' => 'SCH6',
            'state' => 3,
            'status' => true
            ]
        ];

        School::insert($School);
    }
}
