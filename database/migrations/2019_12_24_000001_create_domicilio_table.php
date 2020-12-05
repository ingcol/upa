<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomicilioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domicilios', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('ciudad_id');
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onDelete('cascade');
            $table->string('nombre');
            $table->string('celular');
            $table->string('whatsapp');
            $table->string('descripcion')->nullable();
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
        Schema::dropIfExists('domicilio');
    }
}
