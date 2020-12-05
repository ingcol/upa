<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesionalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesionales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();  
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable(); 
            $table->string('whatsapp')->nullable(); 
            $table->string('paginaweb')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->text('perfil')->nullable();
            $table->text('enfasis')->nullable();
            $table->text('competencias')->nullable();
            $table->text('intereses')->nullable();
            $table->string('tipo')->nullable();

            $table->unsignedInteger('ciudad_id')->nullable();
            $table->foreign('ciudad_id')->references('id')->on('ciudades')->onDelete('set null');         

            $table->unsignedInteger('subprofesion_id')->nullable();
            $table->foreign('subprofesion_id')->references('id')->on('subprofesiones')->onDelete('set null'); 

            $table->string('estado')->nullable();
            $table->string('plan')->nullable();
        
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('profesionales');
    }
}
