<?php

namespace Database\Seeders;

use App\Models\Specie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Specie::create(['name' => 'Bovino']);
        Specie::create(['name' => 'Bufalino']);
    }
}
