<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\WorkSpace;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'work_space_id' => factory(WorkSpace::class)->create()->id,
    ];
});
