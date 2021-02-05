<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        /*factory(\App\State::class,1)->create([
            "id"=> 1,
            "clave"=> "01",
            "name"=> "Aguascalientes",
            "abrev"=> "Ags."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 2,
            "clave"=> "02",
            "name"=> "Baja California",
            "abrev"=> "BC"
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 3,
            "clave"=> "03",
            "name"=> "Baja California Sur",
            "abrev"=> "BCS"
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 4,
            "clave"=> "04",
            "name"=> "Campeche",
            "abrev"=> "Camp."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 5,
            "clave"=> "05",
            "name"=> "Coahuila de Zaragoza",
            "abrev"=> "Coah."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 6,
            "clave"=> "06",
            "name"=> "Colima",
            "abrev"=> "Col."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 7,
            "clave"=> "07",
            "name"=> "Chiapas",
            "abrev"=> "Chis."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 8,
            "clave"=> "08",
            "name"=> "Chihuahua",
            "abrev"=> "Chih."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 9,
            "clave"=> "09",
            "name"=> "Ciudad de México",
            "abrev"=> "CDMX"
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 10,
            "clave"=> 10,
            "name"=> "Durango",
            "abrev"=> "Dgo."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 11,
            "clave"=> 11,
            "name"=> "Guanajuato",
            "abrev"=> "Gto."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 12,
            "clave"=> 12,
            "name"=> "Guerrero",
            "abrev"=> "Gro."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 13,
            "clave"=> 13,
            "name"=> "Hidalgo",
            "abrev"=> "Hgo."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 14,
            "clave"=> 14,
            "name"=> "Jalisco",
            "abrev"=> "Jal."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 15,
            "clave"=> 15,
            "name"=> "México",
            "abrev"=> "Mex."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 16,
            "clave"=> 16,
            "name"=> "Michoacán de Ocampo",
            "abrev"=> "Mich."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 17,
            "clave"=> 17,
            "name"=> "Morelos",
            "abrev"=> "Mor."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 18,
            "clave"=> 18,
            "name"=> "Nayarit",
            "abrev"=> "Nay."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 19,
            "clave"=> 19,
            "name"=> "Nuevo León",
            "abrev"=> "NL"
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 20,
            "clave"=> 20,
            "name"=> "Oaxaca",
            "abrev"=> "Oax."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 21,
            "clave"=> 21,
            "name"=> "Puebla",
            "abrev"=> "Pue."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 22,
            "clave"=> 22,
            "name"=> "Querétaro",
            "abrev"=> "Qro."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 23,
            "clave"=> 23,
            "name"=> "Quintana Roo",
            "abrev"=> "Q. Roo"
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 24,
            "clave"=> 24,
            "name"=> "San Luis Potosí",
            "abrev"=> "SLP"
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 25,
            "clave"=> 25,
            "name"=> "Sinaloa",
            "abrev"=> "Sin."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 26,
            "clave"=> 26,
            "name"=> "Sonora",
            "abrev"=> "Son."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 27,
            "clave"=> 27,
            "name"=> "Tabasco",
            "abrev"=> "Tab."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 28,
            "clave"=> 28,
            "name"=> "Tamaulipas",
            "abrev"=> "Tamps."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 29,
            "clave"=> 29,
            "name"=> "Tlaxcala",
            "abrev"=> "Tlax."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 30,
            "clave"=> 30,
            "name"=> "Veracruz de Ignacio de la Llave",
            "abrev"=> "Ver."
        ]);
        factory(\App\State::class,1)->create([
            "id"=> 31,
            "clave"=> 31,
            "name"=> "Yucatán",
            "abrev"=> "Yuc."
        ]);
        factory(\App\State::class,1)->create([
                "id"=> 32,
                "clave"=> 32,
                "name"=> "Zacatecas",
                "abrev"=> "Zac."
        ]);

       $sql = base_path('database/dump/import_cities.sql');
       DB::unprepared(file_get_contents($sql));*/

        //factory(\App\State::class,)
    	//factory(\App\Customer::class,150)->create();
	    //$this->call(Customer)
        // $this->call(UsersTableSeeder::class);
    }
}
