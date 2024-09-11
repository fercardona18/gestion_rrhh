<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->integer('dias_vacaciones_disponibles')->default(0)->after('dpi');
        });
    }

  
    public function down(): void
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->dropColumn('dias_vacaciones_disponibles');
        });
    }
};
