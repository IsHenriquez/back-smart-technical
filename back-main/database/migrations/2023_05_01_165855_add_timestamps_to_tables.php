<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicles_brand', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('vehicles_model', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('customer', function (Blueprint $table) {
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
        Schema::table('vehicles_brand', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('vehicles_model', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->dropTimestamps();
        });

        Schema::table('customer', function (Blueprint $table) {
            $table->dropTimestamps();
        });

    }
}
