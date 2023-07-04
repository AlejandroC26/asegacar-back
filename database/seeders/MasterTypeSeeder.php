<?php

namespace Database\Seeders;

use App\Models\MasterType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterType::create(['name'=> 'Planilla Diaria Bobinos']);
        MasterType::create(['name'=> 'Planilla Orden de Beneficio']);
        MasterType::create(['name'=> 'Formato Inspección Post Mortem']);
        MasterType::create(['name'=> 'Formato Tolerancia Cero Visceras']);
        MasterType::create(['name'=> 'Formato Inspección Cero Tolerancia']);
        MasterType::create(['name'=> 'Formato Acondicionamiento de la Canal']);
        MasterType::create(['name'=> 'Formato Verificación de Salida de Productos']);
        MasterType::create(['name'=> 'Formato Comparación Decomisos']);
    }
}
