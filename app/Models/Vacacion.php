<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    use HasFactory;

    protected $table = 'vacaciones'; 


    protected $fillable = [
        'empleado_id',
        'fecha_inicio',
        'fecha_fin',
        'dias_solicitados',
        'comerntarios',
        'estado',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
