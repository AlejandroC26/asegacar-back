<?php

namespace Database\Seeders;

use App\Models\AppRoutes;
use App\Models\ChargeRoutes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
            8 => [
                8, 9, 10, 24
            ],
            // MEIDCO VETERINARIO AUX
            5 => [
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
            6 => [
                19, 20, 22, 23
            ],
            // AUXILIAR FACTURACIÓN
            7 => [
                16
            ]
        ];

        Schema::disableForeignKeyConstraints();

        // Limpiar la tabla 'example'
        DB::table('charge_routes')->truncate();

        Schema::enableForeignKeyConstraints();
        
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
