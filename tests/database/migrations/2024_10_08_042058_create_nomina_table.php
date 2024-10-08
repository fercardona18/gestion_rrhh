<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNominaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomina', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleo_id');
            $table->decimal('salario_base', 10, 2);
            $table->decimal('horas_extras', 10, 2)->nullable();
            $table->decimal('deducciones', 10, 2)->nullable();
            $table->decimal('bonificaciones', 10, 2)->nullable();
            $table->decimal('prestaciones', 10, 2)->nullable();
            $table->decimal('total_a_pagar', 10, 2);
            $table->timestamps();
            $table->unsignedBigInteger('empleado_id');
            
            $table->foreign('empleado_id', 'nomina_empleado_id_foreign')->references('id')->on('empleados')->onDelete('cascade');
            $table->foreign('empleo_id', 'nomina_empleo_id_foreign')->references('id')->on('empleos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nomina');
    }
}
