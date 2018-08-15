<?php

use Faker\Generator as Faker;


$factory->define(Linet\Template::class, function (Faker $faker) {
    return [
        'username' => 'win10',
        'name' => 'Desktop Template',
        'developer' => 1,
    ];
});
