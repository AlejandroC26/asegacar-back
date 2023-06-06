<?php

namespace Database\Seeders;

use App\Models\Age;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Age::create(['description'=>'1-2 AÑOS']); 
        Age::create(['description'=>'2-3 AÑOS']); 
        Age::create(['description'=>'> 3 AÑOS']); 
    }
}
