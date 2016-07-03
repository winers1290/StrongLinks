<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbtEmotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbt_emotions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cbt_id');
            $table->integer('emotion_id');
            $table->integer('severity');
            $table->integer('severity_after');
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
        Schema::drop('cbt_emotions');
    }
}
