<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email')->unique('empleados_email_unique');
            $table->string('dpi')->unique('empleados_dpi_unique');
            $table->string('password');
            $table->integer('dias_vacaciones_disponibles')->default(0);
            $table->date('fecha_nacimiento');
            $table->string('estado_civil');
            $table->date('fecha_ingreso')->nullable();
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
        Schema::dropIfExists('empleados');
    }
}
