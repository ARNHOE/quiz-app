<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'question_id' => factory(\App\Question::class)->create()->id,
        'answer' => $faker->word,
    ];
});
