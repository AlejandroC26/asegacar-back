<?php

namespace Database\Seeders;

use App\Models\AppRouteCategories;
use App\Models\Charge;
use App\Models\ChargeCategories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChargeCategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allCharges = Charge::all();
        $allCategories = AppRouteCategories::all();

        Schema::disableForeignKeyConstraints();
        // Limpiar la tabla 'example'
        DB::table('charge_categories')->truncate();

        Schema::enableForeignKeyConstraints();
        
        // ALL CATEGORIES TO ADMIN
        foreach ($allCategories as $categorie) {
            ChargeCategories::updateOrCreate([
                'id_charge' => 1,
                'id_app_route_categorie' => $categorie->id,
            ]);
            ChargeCategories::updateOrCreate([
                'id_charge' => 9,
                'id_app_route_categorie' => $categorie->id,
            ]);
        }
    
        foreach ($allCharges as $charge) {
            ChargeCategories::updateOrCreate([
                'id_charge' => $charge->id,
                'id_app_route_categorie' => 1,
            ]);
        }
        // VETERINARIO OFICIAL
        ChargeCategories::updateOrCreate([
            'id_charge' => 3,
            'id_app_route_categorie' => 7
        ]);
        // JEFE OPERATIVO
        ChargeCategories::updateOrCreate([
            'id_charge' => 4,
            'id_app_route_categorie' => 7
        ]);
        // MÉDICO VETERINARIO AUXILIAR
        ChargeCategories::updateOrCreate([
            'id_charge' => 5,
            'id_app_route_categorie' => 7
        ]);
        // AUXILIAR DE CALIDAD
        ChargeCategories::updateOrCreate([
            'id_charge' => 6,
            'id_app_route_categorie' => 7
        ]);
        // AUXILIAR DE FACTURACIÓN
        ChargeCategories::updateOrCreate([
            'id_charge' => 7,
            'id_app_route_categorie' => 7
        ]);
        // AUXILIAR ADMINISTRATIVO
        ChargeCategories::updateOrCreate([
            'id_charge' => 8,
            'id_app_route_categorie' => 7
        ]);
        // JEFE DE CALIDAD
        ChargeCategories::updateOrCreate([
            'id_charge' => 9,
            'id_app_route_categorie' => 7
        ]);
        // AUXILIAR ADMINISTRATIVO
        ChargeCategories::updateOrCreate([
            'id_charge' => 10,
            'id_app_route_categorie' => 7
        ]);
    }
}
