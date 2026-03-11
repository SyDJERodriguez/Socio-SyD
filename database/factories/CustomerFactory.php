<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        //'client_number'         => \App\ClientNumber::all()->random()->client_number,
	    'name'                  => $faker->name,
	    'last_name'             => $faker->lastName,
	    'second_last_name'      => $faker->lastName,
	    'email'                 => $faker->email,
	    'mobile_number'         => $faker->phoneNumber,
        //'source'                => 'historic',
        'customer_level'        => 3,
	    'branch_id'             => \App\Branch::all()->random()->id
    ];
});
