<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\HistorialLaboral;
use Illuminate\Http\Request;

class HistorialLaboralController extends Controller
{
   
public function create(Empleo $empleo)
{
    return view('historial.create', compact('empleo'));
}

public function store(Request $request, Empleo $empleo)
{
    $validatedData = $request->validate([
        'experiencia_previa' => 'nullable|string',
        'educacion' => 'nullable|string',
        'certificaciones' => 'nullable|string',
    ]);

    $historialLaboral = $empleo->historialLaboral()->create($validatedData);

    return redirect()->route('empleos.index', $empleo->empleado_id)
                     ->with('success', 'Historial laboral creado exitosamente.');
}
}