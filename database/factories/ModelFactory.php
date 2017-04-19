<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Employee::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'age' => $faker->numberBetween(18, 50),
        'jmbg' => $faker->randomNumber(5),
        'project' => $faker->word,
        'department' => $faker->word,
        'isActive' => $faker->numberBetween(0,1)
    ];
});
