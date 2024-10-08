<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialLaboralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_laboral', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado_id');
            $table->unsignedBigInteger('empleo_id')->nullable();
            $table->text('experiencia_previa')->nullable();
            $table->text('educacion')->nullable();
            $table->text('certificaciones')->nullable();
            $table->timestamps()->default('current_timestamp()');
            
            $table->foreign('empleado_id', 'fk_empleado')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('empleo_id', 'historial_laboral_ibfk_1')->references('id')->on('empleos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_laboral');
    }
}
