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

$factory->state(Category::class, 'residential-child', function (Faker $faker) {
    return [
        'name' => 'Category 1',
        'parent_id' => App\Category::where('name', 'residential')->pluck('id')->first()
    ];
});

$factory->state(Category::class, 'commercial-child', function (Faker $faker) {
    return [
        'name' => 'Category 2',
        'parent_id' => App\Category::where('name', 'commercial')->pluck('id')->first()
    ];
});
