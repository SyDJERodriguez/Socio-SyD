<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\City::class, function (Faker $faker){
   return [
      'name' =>  null,
      'clave' => '',
      'state_id' => '',
   ];
});