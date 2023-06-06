<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\City;
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
        $this->call(PersonSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(PurposeSeeder::class);
        $this->call(OutletSeeder::class);
        $this->call(AgeSeeder::class);
    }
}
