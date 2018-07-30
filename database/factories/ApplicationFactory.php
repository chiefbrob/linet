<?php

use Faker\Generator as Faker;
use Linet\Application;


$factory->define(Linet\Application::class, function (Faker $faker) {

	$application = new Application;
	$application->name = "Mtengenezi";
	$application->username = "mtengenezi";
	$application->owner = 1;
	$application->save();

	$application = new Application;
	$application->name = "Settings";
	$application->username = "settings";
	$application->owner = 1;
	$application->save();

	$application = new Application;
	$application->name = "Wenzako";
	$application->username = "wenzako";
	$application->owner = 1;
	$application->save();

	$application = new Application;
	$application->name = "Tumana Shop";
	$application->username = "tumanashop";
	$application->owner = 1;
	$application->save();

	$application = new Application;
	$application->name = "Ujumbe";
	$application->username = "ujumbe";
	$application->owner = 1;
	$application->save();

    return [
        'name' => 'Mwalimu',
        'username' => 'mwalimu',
        'owner' => 1,
    ];
});
