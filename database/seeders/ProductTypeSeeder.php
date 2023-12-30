<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductType::updateOrCreate([ 'name' => 'CARNE EN CANAL', 'amount' => 1 ]);
        ProductType::updateOrCreate([ 'name' => 'CARNE EN MEDIA CANAL', 'amount' => 2 ]);
        ProductType::updateOrCreate([ 'name' => 'CARNE EN CUARTOS DE CANAL', 'amount' => 4 ]);
    }
}
