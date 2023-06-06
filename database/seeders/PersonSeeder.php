<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Person::create([
            "fullname" => "Administrador",
            "document" => "111",
            "expedition_city" => "Pitalito",
            "adress" => "Cra 17",
        ]);
    }
}
