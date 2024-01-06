<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::updateOrCreate([
            'name' => 'Planta de beneficio de ganado bovino del municipio de Pitalito'
        ], [
            'name' => 'Planta de beneficio de ganado bovino del municipio de Pitalito',
            'id_city' => 34,
            'adress' => 'CALLE 14A # 14 -00 BARRIO CÁLAMO',
            'phone' => '3204778689'
        ]);
    }
}
