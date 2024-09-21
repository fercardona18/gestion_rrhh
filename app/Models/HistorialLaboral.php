<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialLaboral extends Model
{
    use HasFactory;

    protected $table = 'historial_laboral'; // Asegúrate de que esto coincide con el nombre de la tabla

    protected $fillable = [
        'empleo_id',
        'experiencia_previa',
        'educacion',
        'certificaciones',
    ];

    public function empleo()
    {
        return $this->belongsTo(Empleo::class);
    }
}