<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5, true),
        'body' => $faker->paragraphs(3, true),
        'published' => 0,
        'published_at' => null,
    ];
});

$factory->state(Post::class, 'published', [
    'published' => 1,
    'published_at' => Carbon::now()->subDays(rand(1, 1000)),
]);
