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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(\App\Models\Admin::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'username' => $faker->email,
        'password' => 'password',
    ];
});

$factory->define(\App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->word,
    ];
});

$factory->define(\App\Models\Brand::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->word,
        'category_uuid' => $faker->uuid,
    ];
});

$factory->define(\App\Models\Branch::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'name' => $faker->word,
        'address' => $faker->address,
        'brand_uuid' => $faker->uuid,
    ];
});


$factory->define(\App\Models\Agent::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'email' => $faker->email,
        'password' => 'password',
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_initial' => $faker->randomElement(['A', 'B', 'C']),
        'contact_number' => rand(9000000000, 9999999999),
        'branch_uuid' => $faker->uuid,
    ];
});

$factory->define(\App\Models\Customer::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'email' => $faker->email,
        'password' => 'password',
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'middle_initial' => $faker->randomElement(['A', 'B', 'C']),
        'contact_number' => rand(9000000000, 9999999999),
    ];
});
