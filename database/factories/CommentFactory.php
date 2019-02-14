<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'text' => $faker->sentence,
        'user_id' => rand(1, 2)
    ];
});
