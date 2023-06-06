<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::updateOrCreate(
            ['name' => 'Amazonas']
          );
        Department::updateOrCreate(
        ['name' => 'Antioquia']
        );
        Department::updateOrCreate(
        ['name' => 'Arauca']
        );
        Department::updateOrCreate(
        ['name' => 'Atlántico']
        );
        Department::updateOrCreate(
        ['name' => 'Bogota D.C.']
        );
        Department::updateOrCreate(
        ['name' => 'Bolívar']
        );
        Department::updateOrCreate(
        ['name' => 'Boyacá']
        );
        Department::updateOrCreate(
        ['name' => 'Caldas']
        );
        Department::updateOrCreate(
        ['name' => 'Caquetá']
        );
        Department::updateOrCreate(
        ['name' => 'Casanare']
        );
        Department::updateOrCreate(
        ['name' => 'Cauca']
        );
        Department::updateOrCreate(
        ['name' => 'Cesar']
        );
        Department::updateOrCreate(
        ['name' => 'Chocó']
        );
        Department::updateOrCreate(
        ['name' => 'Córdoba']
        );
        Department::updateOrCreate(
        ['name' => 'Cundinamarca']
        );
        Department::updateOrCreate(
        ['name' => 'Guainía']
        );
        Department::updateOrCreate(
        ['name' => 'Guaviare']
        );
        Department::updateOrCreate(
        ['name' => 'Huila']
        );
        Department::updateOrCreate(
        ['name' => 'La Guajira']
        );
        Department::updateOrCreate(
        ['name' => 'Magdalena']
        );
        Department::updateOrCreate(
        ['name' => 'Meta']
        );
        Department::updateOrCreate(
        ['name' => 'Nariño']
        );
        Department::updateOrCreate(
        ['name' => 'Norte de Santander']
        );
        Department::updateOrCreate(
        ['name' => 'Putumayo']
        );
        Department::updateOrCreate(
        ['name' => 'Quindío']
        );
        Department::updateOrCreate(
        ['name' => 'Risaralda']
        );
        Department::updateOrCreate(
        ['name' => 'San Andrés y Providencia']
        );
        Department::updateOrCreate(
        ['name' => 'Santander']
        );
        Department::updateOrCreate(
        ['name' => 'Sucre']
        );
        Department::updateOrCreate(
        ['name' => 'Tolima']
        );
        Department::updateOrCreate(
        ['name' => 'Valle del Cauca']
        );
        Department::updateOrCreate(
        ['name' => 'Vaupés']
        );
        Department::updateOrCreate(
        ['name' => 'Vichada']
        );
    }
}
