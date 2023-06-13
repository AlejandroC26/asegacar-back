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
        Causes::create(['name'=> 'DISTOMATOSIS']);
        Causes::create(['name'=> 'TELANGECTASIA']);
        Causes::create(['name'=> 'De. GRASA ']);
        Causes::create(['name'=> 'TUMORES']);
        Causes::create(['name'=> 'ABSCESOS']);
        Causes::create(['name'=> 'CIRROSIS']);
        Causes::create(['name'=> 'CONGESTIÓN']);
        Causes::create(['name'=> 'HIDRONEFROSIS']);
        Causes::create(['name'=> 'PARÁSITOS']);
        Causes::create(['name'=> 'QUISTES PARASITARIOS']);
        Causes::create(['name'=> 'PERITONITIS']);
        Causes::create(['name'=> 'TRAUMATISMOS']);
        Causes::create(['name'=> 'HEMATOMAS']);
        Causes::create(['name'=> 'CROMATOSIS']);
        Causes::create(['name'=> 'MIASIS']);
        Causes::create(['name'=> 'NECROSIS']);
        Causes::create(['name'=> 'ADHERENCIAS']);
        Causes::create(['name'=> 'ENFISEMA']);
        Causes::create(['name'=> 'BRONCO ASPIRACIÓN']);
        Causes::create(['name'=> 'HEMORRÁGICO']);
        Causes::create(['name'=> 'DESHIDRATACION']);
    }
}
