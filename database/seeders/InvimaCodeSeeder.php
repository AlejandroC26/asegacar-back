<?php

namespace Database\Seeders;

use App\Models\InvimaCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvimaCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvimaCode::updateOrCreate([
            'year' => 2023
        ], [
            'year' => 2023,
            'codes' => 1000
        ]);

        InvimaCode::updateOrCreate([
            'year' => 2024
        ], [
            'year' => 2024,
            'codes' => 1000
        ]);
    }
}
