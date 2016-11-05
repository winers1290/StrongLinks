<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbtAutomaticThoughtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbt_automatic_thoughts', function (Blueprint $table) {
            $table->increments('id');
	    $table->integer('cbt_id');
	    $table->string('thought');
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
        Schema::drop('cbt_automatic_thoughts');
    }
}
