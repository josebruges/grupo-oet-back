<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('cedula', 191)->unique();
            $table->string('correo', 191)->unique();
            $table->string('telefono');
            $table->string('password');
            $table->longText('cedula_front')->nullable();
            $table->longText('cedula_later')->nullable();
            $table->string('address')->default('N/A');
            $table->string('code');
            $table->string('status')->default('false');
            
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
        Schema::dropIfExists('users');
    }
}
