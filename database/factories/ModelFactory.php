<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {

    $salt = str_random();

    return [
        'username'      => $faker->userName,
        'role'          => 1,
        'password'      => Hash::make($salt . 'password'),
        'salt'          => $salt,
    ];
});

$factory->define(App\Profile::class, function (Faker\Generator $faker) {

    return [
        'email'         => $faker->email,
        'first_name'    => rand(1, 1000),
        'last_name'     => rand(1,1000),
        'bio'           => $faker->text(255),
        'picture'       => 'profile.jpeg',
    ];

});

$factory->define(App\Post::class, function (Faker\Generator $faker) {

    return [
        'type'          => 1,
        'content'       => $faker->text(300),
        'special'       => NULL,
    ];

});

$factory->define(App\ObjectComment::class, function (Faker\Generator $faker) {

    return [
        'object_id'          => rand(1,500),
        'object_type'         => rand(1,2),
        'user_id'       => rand(1,50),
        'comment'       => $faker->text(100),
    ];

});

$factory->define(App\PostEmotion::class, function (Faker\Generator $faker) {

    return [
        'post_id'          => rand(1,500),
        'user_id'       => rand(1,50),
        'emotion_id'       => rand(1,5),
        'severity'      =>  rand(1,10),
    ];

});

$factory->define(App\ObjectReaction::class, function (Faker\Generator $faker) {

    return [
        'object_id'          => rand(1,500),
        'object_type'         => rand(1,2),
        'user_id'       => rand(1,50),
        'emotion_id'       => rand(1,5),
    ];

});

$factory->define(App\CBT::class, function (Faker\Generator $faker) {

    return [
        'situation'     => $faker->text(100),
        'privacy'       => rand(1,3),
        'general'       => rand(1,10),
        'general_after'       => rand(1,10),
    ];

});

$factory->define(App\CBTEvidence::class, function (Faker\Generator $faker) {

    return [
        'cbt_id'     => rand(1,50),
        'supportive'       => rand(0,1),
        'evidence'       => $faker->text(35),
    ];

});

$factory->define(App\CBTAutomaticThought::class, function (Faker\Generator $faker) {

    return [
        'cbt_id'     => rand(1,50),
        'thought'       => $faker->text(rand(100,150)),
        'severity'       => rand(1,100),
        'severity_after'    => rand(1,100),
    ];

});

$factory->define(App\CBTRationalThought::class, function (Faker\Generator $faker) {

    return [
        'cbt_id'     => rand(1,50),
        'thought'   => $faker->text(rand(100,150)),
    ];

});

$factory->define(App\CBTEmotion::class, function (Faker\Generator $faker) {

    return [
        'cbt_id'     => rand(1,50),
        'emotion_id'   => rand(1,5),
        'severity'   => rand(1,10),
        'severity_after'   => rand(1,10),
    ];

});





$factory->define(App\Name::class, function (Faker\Generator $faker) {

    $i = rand(1,2);

    if($i == 1)
    {
        return [
            'name'          => $faker->lastName,
        ];
    }

    else
    {
        return [
            'name'          => $faker->firstName,
        ];
    }



});
