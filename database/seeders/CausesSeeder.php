<?php

namespace Database\Seeders;

use App\Models\Causes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CausesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Causes::updateOrCreate(['name'=> 'DISTOMATOSIS']);
        Causes::updateOrCreate(['name'=> 'TELANGECTASIA']);
        Causes::updateOrCreate(['name'=> 'De. GRASA ']);
        Causes::updateOrCreate(['name'=> 'TUMORES']);
        Causes::updateOrCreate(['name'=> 'ABSCESOS']);
        Causes::updateOrCreate(['name'=> 'CIRROSIS']);
        Causes::updateOrCreate(['name'=> 'CONGESTIÓN']);
        Causes::updateOrCreate(['name'=> 'HIDRONEFROSIS']);
        Causes::updateOrCreate(['name'=> 'PARÁSITOS']);
        Causes::updateOrCreate(['name'=> 'QUISTES PARASITARIOS']);
        Causes::updateOrCreate(['name'=> 'PERITONITIS']);
        Causes::updateOrCreate(['name'=> 'TRAUMATISMOS']);
        Causes::updateOrCreate(['name'=> 'HEMATOMAS']);
        Causes::updateOrCreate(['name'=> 'CROMATOSIS']);
        Causes::updateOrCreate(['name'=> 'MIASIS']);
        Causes::updateOrCreate(['name'=> 'NECROSIS']);
        Causes::updateOrCreate(['name'=> 'ADHERENCIAS']);
        Causes::updateOrCreate(['name'=> 'ENFISEMA']);
        Causes::updateOrCreate(['name'=> 'BRONCO ASPIRACIÓN']);
        Causes::updateOrCreate(['name'=> 'HEMORRÁGICO']);
        Causes::updateOrCreate(['name'=> 'DESHIDRATACION']);
        Causes::updateOrCreate(['name'=> 'PRODUCCIÓN LÁCTICA']);
        Causes::updateOrCreate(['name'=> 'MATERIA ORGÁNICA']);
        Causes::updateOrCreate(['name'=> 'CONTENIDO RUMINAL']);
        Causes::updateOrCreate(['name'=> 'MATERIA FECAL']);
    }
}
