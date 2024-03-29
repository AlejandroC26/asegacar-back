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
        $this->call(ProductTypeSeeder::class);
        $this->call(ChargeSeeder::class);
        $this->call(PersonSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(ColorSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(PurposeSeeder::class);
        $this->call(OutletSeeder::class);
        $this->call(AgeSeeder::class);
        $this->call(MasterTypeSeeder::class);
        $this->call(CausesSeeder::class);
        $this->call(SpecieSeeder::class);
        // ROUTE AND PERMISSIONS
        $this->call(AppRouteCategorieSeeder::class);
        $this->call(AppRouteSeeder::class);
        $this->call(ChargeCategorieSeeder::class);
        $this->call(ChargeRouteSeeder::class);
    }
}
