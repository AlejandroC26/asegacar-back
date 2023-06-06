<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Outlet::create([
            'code' => '1',
            'customer' => 'TULIO EFREN MORALES',
            'primary_phone' => '3168360949',
            'secondary_phone' => '',
            'establishment_name' => 'FAMA N°1',
            'establishment_address' => 'CALLE 10 N 13-00 GALERIA',
        ]);
    }
}
