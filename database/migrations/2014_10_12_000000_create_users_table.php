<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('nombre',100);
            $table->string('apellido',100);
            $table->string('dni',8);
            $table->string('login',50);
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('activo');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('rol_id')->unsigned();
            $table->foreign('rol_id')->references('id')->on('rols');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
