<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    use HasFactory;

    protected $table = 'nomina'; 

    protected $fillable = [
        'empleado_id',
        'empleo_id',
        'salario_base',
        'horas_extras',
        'deducciones',
        'bonificaciones',
        'prestaciones',
        'total_a_pagar',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id'); 
    }
}