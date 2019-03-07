<?php

use Faker\Generator as Faker;
use App\Category;
use App\User;

$factory->define(App\Post::class, function (Faker $faker) {
    $title = $faker->sentence;
    $body = $faker->text(1000);
    return [
        'title' => $title,
        'slug' => str_slug($title),
        'body' => $body,
        'description' => shortenText($body, 26),
        'user_id' => function () {
            return User::all()->random();
        },
        'category_id' => function () {
            return Category::all()->random();
        }
    ];
});
