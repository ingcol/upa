<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicidades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ciudad_id')->nullable();
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onDelete('set null');
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('url')->nullable();
            $table->string('intermedia')->nullable();
            $table->string('banner')->nullable();
            $table->string('categoria');
            $table->string('estado');
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
        Schema::dropIfExists('publicidades');
    }
}
