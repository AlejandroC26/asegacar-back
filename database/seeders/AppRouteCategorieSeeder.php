<?php

namespace Database\Seeders;

use App\Models\AppRouteCategories;
use Illuminate\Database\Seeder;

class AppRouteCategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppRouteCategories::updateOrCreate([
            'icon' => 'home',
            'label' => 'Inicio',
            'route' => 'admin',
        ]);

        AppRouteCategories::updateOrCreate([
            'icon' => 'settings',
            'label' => 'Configuración',
        ]);

        AppRouteCategories::updateOrCreate([
            'icon' => 'fact_check',
            'label' => 'Recepción',
        ]);

        AppRouteCategories::updateOrCreate([
            'icon' => 'history',
            'label' => 'Ante-Mortem',
        ]);

        AppRouteCategories::updateOrCreate([
            'icon' => 'feed',
            'label' => 'Verificación Post-Mortem',
        ]);

        AppRouteCategories::updateOrCreate([
            'icon' => 'local_shipping',
            'label' => 'Despacho',
        ]);

        AppRouteCategories::updateOrCreate([
            'icon' => 'fact_check',
            'label' => 'Reportes',
            'route' => 'reportes',
        ]);
    }
}
