<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_ingreso',
        'puesto',
        'departamento',
        'tipo_contrato',
        'salario_base',
        'empleado_id', // Asegúrate de incluir el ID del empleado
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function historialLaboral()
    {
        return $this->hasOne(HistorialLaboral::class);
    }

    public function nomina()
    {
        return $this->hasMany(Nomina::class);
    }
}