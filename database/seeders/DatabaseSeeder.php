<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\BarangaySeeder;
use Database\Seeders\ViolationCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ViolationCategorySeeder::class, 
            AdminUserSeeder::class,
            RegionSeeder::class,
            ProvinceSeeder::class,
            CitiesMunicipalitiesSeeder::class,
            // BarangaySeeder::class,
        ]);
    }
}
