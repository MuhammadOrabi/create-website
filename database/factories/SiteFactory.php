<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(App\Site::class, function (Faker $faker) {
    return [
        'address' => $faker->unique()->name,
    ];
});
