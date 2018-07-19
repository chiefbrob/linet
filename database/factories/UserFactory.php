<?php

use Faker\Generator as Faker;


$factory->define(Linet\User::class, function (Faker $faker) {
    return [
        'name' => 'Timothy',
        'username' => 'timo',
        'phone' => '0700000000',
        'email' => 'timo@lughayetu.net',
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
