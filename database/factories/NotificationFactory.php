<?php

use Faker\Generator as Faker;
use Linet\Application;


$factory->define(Linet\Notification::class, function (Faker $faker) {

	$app = Application::findOrFail(rand(1,4));

    return [
        'contents' => $faker->paragraph(2),
        'sender' => $app->username,
        'user' => 1,
    ];
    
});
