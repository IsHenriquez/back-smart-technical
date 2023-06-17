<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechnicalServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('technical_service', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estado')->comment('1: pendiente, 2:activo, 3: terminado, 4:cancelado');
            $table->text('decripcion');
            $table->unsignedBigInteger('id_vehicle');
            $table->unsignedBigInteger('id_customer');
            $table->string('address');
            $table->double('latitude');
            $table->double('longitude');
            $table->dateTime('fecha_ingreso_solicitud')->nullable();
            $table->dateTime('fecha_realizar_servicio')->nullable();
            $table->dateTime('fecha_termino_servicio')->nullable();
            $table->timestamps();

            $table->foreign('id_vehicle')
            ->references('id')
            ->on('vehicles')
            ->onUpdate('cascade')
            ->onDelete('restrict');

            $table->foreign('id_customer')
            ->references('id')
            ->on('customer')
            ->onUpdate('cascade')
            ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technical_service');
    }
}
