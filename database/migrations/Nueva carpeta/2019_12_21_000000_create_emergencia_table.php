<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergencia', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ciudad_id');
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onDelete('cascade');
            $table->string('nombre');
            $table->string('celular');
            $table->string('icono');
            $table->string('orden');
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('emergencia');
    }
}
