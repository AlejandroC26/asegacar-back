<?php

namespace Database\Seeders;

use App\Models\Charge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Charge::updateOrCreate(['name' => 'Administrativo']);
        Charge::updateOrCreate(['name' => 'Propietario']);
        Charge::updateOrCreate(['name' => 'Veterinario']);
    }
}
