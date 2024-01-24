<?php

namespace Database\Seeders;

use App\Models\AppRouteCategories;
use App\Models\Charge;
use App\Models\ChargeCategories;
use Illuminate\Database\Seeder;

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
        // ALL CATEGORIES TO ADMIN
        foreach ($allCategories as $categorie) {
            ChargeCategories::updateOrCreate([
                'id_charge' => 1,
                'id_app_route_categorie' => $categorie->id,
            ]);
        }
    
        foreach ($allCharges as $charge) {
            ChargeCategories::updateOrCreate([
                'id_charge' => $charge->id,
                'id_app_route_categorie' => 1,
            ]);
        }
        // VETERINARIO
        ChargeCategories::updateOrCreate([
            'id_charge' => 3,
            'id_app_route_categorie' => 7
        ]);
    }
}
