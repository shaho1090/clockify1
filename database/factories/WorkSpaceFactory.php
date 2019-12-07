<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\WorkSpace;
use Faker\Generator as Faker;

$factory->define(WorkSpace::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
    ];
});
