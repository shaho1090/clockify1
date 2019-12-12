<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\WorkSpace;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(WorkSpace::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
    ];
});
