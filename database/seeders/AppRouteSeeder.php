<?php

namespace Database\Seeders;

use App\Models\AppRoutes;
use Illuminate\Database\Seeder;

class AppRouteSeeder extends Seeder
{
    public function run()
    {
        // CONFIGURACIÓN
        AppRoutes::updateOrCreate([
            'label' => 'Personas',
            'route' => 'personas',
            'id_app_route_categories' => 2
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Usuarios',
            'route' => 'usuarios',
            'id_app_route_categories' => 2
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Expendios',
            'route' => 'expendios',
            'id_app_route_categories' => 2
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Guías',
            'route' => 'guias',
            'id_app_route_categories' => 2
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Rutas',
            'route' => 'rutas',
            'id_app_route_categories' => 2
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Vehiculos',
            'route' => 'vehiculos',
            'id_app_route_categories' => 2
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Firmas',
            'route' => 'firmas',
            'id_app_route_categories' => 2
        ]);

        // RECEPCIÓN
        AppRoutes::updateOrCreate([
            'label' => 'Planilla Ingreso',
            'route' => 'planillaingreso',
            'id_app_route_categories' => 3
        ]);
        AppRoutes::updateOrCreate([
            'label' => 'Planilla Diaria',
            'route' => 'planilladiaria',
            'id_app_route_categories' => 3
        ]);
        AppRoutes::updateOrCreate([
            'label' => 'Sacrificios Pendientes',
            'route' => 'sacrificiospendientes',
            'id_app_route_categories' => 3
        ]);

        // ANTE MORTEM
        AppRoutes::updateOrCreate([
            'label' => 'Inspección Antemortem',
            'route' => 'inspeccionantemortem',
            'id_app_route_categories' => 4
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Registro Hembras Paridas',
            'route' => 'registrohembrasparidas',
            'id_app_route_categories' => 4
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Animales Sospechosos',
            'route' => 'animalessospechosos',
            'id_app_route_categories' => 4
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Ingreso Bovinos Emergencia',
            'route' => 'ingresobovinosemergencia',
            'id_app_route_categories' => 4
        ]);

        //  VERIFICACIÓN POST - MORTEM
        AppRoutes::updateOrCreate([
            'label' => 'Ruta Diaria',
            'route' => 'rutadiaria',
            'id_app_route_categories' => 5
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Planilla Orden Beneficio',
            'route' => 'planillaordenbeneficio',
            'id_app_route_categories' => 5
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Inspección Post Mortem',
            'route' => 'inspeccionpostmortem',
            'id_app_route_categories' => 5
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Tolerancia Cero Visceras',
            'route' => 'toleranciacerovisceras',
            'id_app_route_categories' => 5
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Inspección Cero Tolerancia',
            'route' => 'inspeccioncerotolerancia',
            'id_app_route_categories' => 5
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Acondicionamiento De La Canal',
            'route' => 'acondicionamientodelacanal',
            'id_app_route_categories' => 5
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Despacho Visceras',
            'route' => 'despachovisceras',
            'id_app_route_categories' => 5
        ]);

        AppRoutes::updateOrCreate([
            'label' => 'Comparación Decomisos',
            'route' => 'comparaciondecomisos',
            'id_app_route_categories' => 5
        ]);

        // DESPACHO
        AppRoutes::updateOrCreate([
            'label' => 'Guía de despacho',
            'route' => 'guiadespacho',
            'id_app_route_categories' => 6
        ]);
    }
}
