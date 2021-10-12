<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\User::class, function (Faker $faker) {
    $email =  $faker->unique()->safeEmail;
    $username = $email;
    $phone = $faker->phoneNumber;
    $token = base64_encode(strtolower($email.'.'.str_random(10)));
    return [
        "username"=>$username,
        "email"=>$email,
        "phone"=>$phone,
        "password"=>bcrypt("secret"),
        "confirm"=>1,
        "remember_token"=>$token,
    ];

});
