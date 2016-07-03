<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique;
            $table->tinyInteger('role');
            $table->string('password');
            $table->string('salt');
            $table->string('reset_key');
            $table->dateTime('reset_expiry')->default(NULL)->nullable();
            $table->string('facebook_token')->default(NULL)->nullable();
            $table->string('last_ip');
            $table->boolean('banned')->default(FALSE);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
