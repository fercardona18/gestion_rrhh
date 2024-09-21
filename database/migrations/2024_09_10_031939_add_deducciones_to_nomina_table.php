<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::table('nomina', function (Blueprint $table) {
            $table->decimal('igss', 8, 2)->nullable()->after('salario_base'); // Ajusta según tu estructura
            $table->decimal('irtra', 8, 2)->nullable()->after('igss');
            $table->decimal('intecap', 8, 2)->nullable()->after('irtra');
        });
    }

    
    public function down(): void
    {
        Schema::table('nomina', function (Blueprint $table) {
            $table->dropColumn(['igss', 'irtra', 'intecap']);
        });
    }
};
