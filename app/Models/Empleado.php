<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    // Especifica los atributos que se pueden asignar masivamente
    protected $fillable = [
        'name',
        'dpi',
        'password',
        'direccion',
        'telefono',
        'email',
        'fecha_nacimiento',
        'estado_civil',
        'fecha_ingreso',
        'puesto',
        'departamento',
        'tipo_contrato',
        'salario_base',
        'dias_vacaciones_disponibles',
    ];

    // Relación uno a muchos con Empleo
    public function empleos()
    {
        return $this->hasMany(Empleo::class);
    }

    // Relación uno a uno con HistorialLaboral
    public function historialLaboral()
    {
        return $this->hasOne(HistorialLaboral::class);
    }


    // Relación uno a uno con Nomina
    public function nomina()
    {
        return $this->hasOne(Nomina::class);
    }
    //relacion con vacaciones
    public function vacaciones()
{
    return $this->hasMany(Vacacion::class);
}
}