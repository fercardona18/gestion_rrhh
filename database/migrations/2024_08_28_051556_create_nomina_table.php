<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominaTable extends Migration
{
    public function up()
    {
        Schema::create('nomina', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleo_id')->constrained()->onDelete('cascade');
            $table->decimal('salario_base', 10, 2);
            $table->decimal('horas_extras', 10, 2)->nullable();
            $table->decimal('deducciones', 10, 2)->nullable();
            $table->decimal('bonificaciones', 10, 2)->nullable();
            $table->decimal('prestaciones', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nomina');
    }
}