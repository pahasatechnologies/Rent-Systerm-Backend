<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [];
});

// $factory->define(User::class, function (Faker $faker) {
//     return [
//         'first_name' => 'Admin',
//         'last_name' => 'Potter',
//         'email' => 'admin@example.com',
//         'phone' => '9000000000',
//         'role' => 'admin',
//         'email_verified_at' => now(),
//         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//         'remember_token' => Str::random(10),
//     ];
// });

$factory->state(User::class, 'admin', function (Faker $faker) {
    return [
        'first_name' => 'Admin',
        'last_name' => 'Potter',
        'email' => 'admin@example.com',
        'phone' => '9000000000',
        'role' => 'admin',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class, 'landlord', function (Faker $faker) {
    return [
        'first_name' => 'Landlord',
        'last_name' => 'Potter',
        'email' => 'landlord@example.com',
        'phone' => '9111111111',
        'role' => 'landlord',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class, 'tenant', function (Faker $faker) {
    return [
        'first_name' => 'Admin',
        'last_name' => 'Potter',
        'email' => 'tenant@example.com',
        'phone' => '9222222222',
        'role' => 'tenant',
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});
