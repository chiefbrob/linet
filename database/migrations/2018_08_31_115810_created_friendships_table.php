<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedFriendshipsTable extends Migration
{
    
    public function up()
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requester');
            $table->integer('requested');
            $table->string('status',50)->default('sent');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('friendships');
    }
}
