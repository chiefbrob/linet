<?php

use Faker\Generator as Faker;
use Linet\Application;


$factory->define(Linet\Application::class, function (Faker $faker) {

	$application = new Application;
	$application->name = "Mtengenezi";
	$application->username = "mtengenezi";
	$application->icon = "mtengenezi";
	$application->owner = 1;
	$application->description = "Application manager";
	$application->save();

	$application = new Application;
	$application->name = "Settings";
	$application->username = "settings";
	$application->icon = "settings";
	$application->owner = 1;
	$application->description = "Configuracion";
	$application->save();

	$application = new Application;
	$application->name = "Wenzangu";
	$application->username = "wenzangu";
	$application->icon = "wenzangu";
	$application->owner = 1;
	$application->description = "Contact list manager";
	$application->save();

	$application = new Application;
	$application->name = "Tumana Shop";
	$application->username = "tumanashop";
	$application->icon = "tumanashop";
	$application->owner = 1;
	$application->description = "E-commerce";
	$application->save();

	$application = new Application;
	$application->name = "Ujumbe";
	$application->username = "ujumbe";
	$application->icon = "ujumbe";
	$application->owner = 1;
	$application->description = "Message people in your contact list";
	$application->save();

    return [
        'name' => 'Mwalimu',
        'username' => 'mwalimu',
        'icon' => 'mwalimu',
        'owner' => 1,
        'description' => 'This application enables you to study online. Its your personal teacher',
    ];
});
