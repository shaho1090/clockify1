<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Project;
use App\WorkSpace;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
       'title' => $faker->title,
    ];
});
