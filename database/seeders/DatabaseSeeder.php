<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UserSeeder::class]);
        $this->call([RoleSeeder::class]);
        $this->call([UserRoleSeeder::class]);
        $this->call([StateSeeder::class]);
        $this->call([LgaSeeder::class]);
        $this->call([ServiceSeeder::class]);
        $this->call([ServiceFeeMetaSeeder::class]);
        $this->call([BatchSeeder::class]);
        $this->call([SchoolSeeder::class]);
        $this->call([TierSeeder::class]);
        
        // $this->call([MEPTPApplicationSeeder::class]);
        // $this->call([MEPTPIndexNumberSeeder::class]);
        // $this->call([MEPTPResultSeeder::class]);
    }
}
