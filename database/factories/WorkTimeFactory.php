<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Project;
use App\Tag;
use App\WorkTime;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(WorkTime::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'start_time' => Carbon::parse(now()),
        'stop_time' => Carbon::parse('+2 Hours'),
        'project_id' => factory(Project::class)->create()->id,
        'billable' => rand(false, true),
    ];
});
