<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpleadoIdToHistorialLaboralTable extends Migration
{
    public function up()
    {
        Schema::table('historial_laboral', function (Blueprint $table) {
            $table->unsignedBigInteger('empleado_id')->after('id'); // Ajusta la posición según sea necesario
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade'); // Si tienes una tabla empleados
        });
    }

    public function down()
    {
        Schema::table('historial_laboral', function (Blueprint $table) {
            $table->dropForeign(['empleado_id']);
            $table->dropColumn('empleado_id');
        });
    }
}