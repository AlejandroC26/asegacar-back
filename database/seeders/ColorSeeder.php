<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::create(['name'=>'NG']); 
        Color::create(['name'=>'SR']); 
        Color::create(['name'=>'PD']); 
        Color::create(['name'=>'BL']); 
        Color::create(['name'=>'AM']); 
        Color::create(['name'=>'CL']); 
        Color::create(['name'=>'CN']); 
        Color::create(['name'=>'MCH']); 
        Color::create(['name'=>'RJ']); 
    }
}
