<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostEmotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_emotions', function (Blueprint $table) {
            $table->increments('id');
	    $table->integer('post_id');
	    $table->integer('user_id');
	    $table->integer('emotion_id');
	    $table->integer('severity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('post_emotions');
    }
}
