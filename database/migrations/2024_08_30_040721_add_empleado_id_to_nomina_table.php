<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpleadoIdToNominaTable extends Migration
{
    public function up()
    {
        Schema::table('nomina', function (Blueprint $table) {
            $table->foreignId('empleado_id')->constrained()->after('id')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('nomina', function (Blueprint $table) {
            $table->dropForeign(['empleado_id']);
            $table->dropColumn('empleado_id');
        });
    }
}             
