<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use App\Project;
use App\WorkSpace;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'title' => Str::random(6).' project',
        'work_space_id' => function() {
            return factory(WorkSpace::class)->create()->id;
        } ,

    ];
});
