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
        $record = Charge::where('name', 'Administrativo')->orWhere('name', 'Administrativo')->firstOrNew();
        $record->name = 'Administrador';
        $record->save();
        
        Charge::updateOrCreate(['name' => 'Propietario']);

        $record = Charge::where('name', 'Veterinario')->orWhere('name', 'Médico veterinario oficial')->firstOrNew();
        $record->name = 'Médico veterinario oficial';
        $record->save();

        Charge::updateOrCreate(['name' => 'Médico veterinario auxiliar']);
        Charge::updateOrCreate(['name' => 'Jefe operativo']);
        Charge::updateOrCreate(['name' => 'Auxiliar de calidad']);
        Charge::updateOrCreate(['name' => 'Auxiliar facturación']);
        Charge::updateOrCreate(['name' => 'Auxiliar administrativo']);
    }
}
