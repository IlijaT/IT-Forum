<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thread;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'user_id' => factory(App\User::class),
        'channel_id' => factory(App\Channel::class),
        'title' => $title,
        'slug' => Str::slug($title),
        'body' => $faker->paragraph,
        'locked' => false,
        'visits' => 0,
    ];
});
