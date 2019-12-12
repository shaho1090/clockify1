<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use App\WorkSpace;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'title' => Str::random(6).' tag',
        'work_space_id' =>  function() {
            return factory(WorkSpace::class)->create()->id;
        } ,
    ];
});
