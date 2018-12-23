<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(Linet\User::class,1)->create();
        factory(Linet\Template::class,1)->create();
        factory(Linet\Application::class,1)->create();
        //factory(Linet\Notification::class,5)->create();
    }
}
