<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [];
});

$factory->state(Category::class, 'residential', function (Faker $faker) {
    return [
        'name' => 'residential',
    ];
});

$factory->state(Category::class, 'commercial', function (Faker $faker) {
    return [
        'name' => 'commercial',
    ];
});
