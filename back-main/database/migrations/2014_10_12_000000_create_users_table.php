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
            $table->boolean('activo')->default(1);
            $table->unsignedBigInteger('tipo_usuario')->comment('1: administrativo, 2:tecnico');
            $table->string('name');
            $table->string('apellido_paterno',50);
            $table->string('apellido_materno',50)->nullable();
            $table->string('rut',20)->nullable();
            $table->string('genero',1)->comment('M o F')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('fono_movil',20)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('users');
    }
}
