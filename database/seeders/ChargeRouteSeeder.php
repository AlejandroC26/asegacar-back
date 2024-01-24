<?php

namespace Database\Seeders;

use App\Models\AppRoutes;
use App\Models\ChargeRoutes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChargeRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allRoutes = AppRoutes::all();
        $aChargeRoutes = [
            // AUX ADMINISTRATIVO
            9 => [
                8, 9, 10, 24
            ],
            // MEIDCO VETERINARIO AUX
            6 => [
                9, 11, 13, 14, 15, 18
            ],
            // MEDICO VETERINARIO OFICIAL
            3 => [
                9, 11, 13, 14, 15, 18
            ],
            // jefe operativo
            4 => [
                5, 9, 16, 17
            ],
            // AUXILIAR CALIDAD
            7 => [
                19, 20, 22, 23
            ],
            // AUXILIAR FACTURACIÓN
            8 => [
                16
            ]
        ];


        foreach ($allRoutes as $route) {
            ChargeRoutes::updateOrCreate([
                'id_charge' => 1,
                'id_app_route' => $route->id
            ]);
        }

        foreach ($aChargeRoutes as $charge => $routes) {
            foreach ($routes as $route) {
                ChargeRoutes::updateOrCreate([
                    'id_charge' => $charge,
                    'id_app_route' => $route
                ]);
            }
        }
    }
}
