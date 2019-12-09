<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\User;
use App\UserWorkSpace;
use App\WorkSpace;
use Faker\Generator as Faker;

$factory->define(UserWorkSpace::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'work_space_id' => factory(WorkSpace::class)->create()->id,
        'access' => integerValue(),
        'active' => integerValue(),
    ];
});
