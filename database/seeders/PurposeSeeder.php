<?php

namespace Database\Seeders;

use App\Models\Purpose;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Purpose::create(['name' => 'PROPOSITO CARNE']);
        Purpose::create(['name' => 'PROPOSITO LECHE']);
        Purpose::create(['name' => 'DOBLE PROPOSITO']);
        Purpose::create(['name' => 'PROPOSITO MAMONA']);
    }
}
