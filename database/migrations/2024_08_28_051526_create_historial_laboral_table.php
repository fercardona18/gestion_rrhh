<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialLaboralTable extends Migration
{
    public function up()
    {
        Schema::create('historial_laboral', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleo_id')->constrained()->onDelete('cascade');
            $table->text('experiencia_previa')->nullable();
            $table->text('educacion')->nullable();
            $table->text('certificaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('historial_laboral');
    }
}