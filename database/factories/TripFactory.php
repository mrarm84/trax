<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Trip::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTime,
        'miles' => $faker->randomNumber(1),
        'total' => $faker->randomNumber(1),
        'car_id' => function () {
            return factory(App\Car::class)->create()->id;
        }
    ];
});
