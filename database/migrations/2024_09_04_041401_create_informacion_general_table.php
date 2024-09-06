<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionGeneralTable extends Migration
{
    public function up()
    {
        Schema::create('informacion_general', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); // Título de la información
            $table->text('contenido'); // Contenido de la información
            $table->enum('tipo', ['responsabilidad', 'anuncio', 'informacion_general']); // Tipo de información
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('informacion_general');
    }
}