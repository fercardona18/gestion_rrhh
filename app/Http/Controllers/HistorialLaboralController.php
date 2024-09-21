<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Empleo;
use App\Models\HistorialLaboral;
use Illuminate\Http\Request;

class HistorialLaboralController extends Controller
{
    // Muestra el formulario para crear un nuevo historial laboral
    public function create(Empleo $empleo)
    {
        return view('historial.create', compact('empleo'));
    }

    // Almacena un nuevo historial laboral
    public function store(Request $request, Empleo $empleo)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'experiencia_previa' => 'nullable|string',
            'educacion' => 'nullable|string',
            'certificaciones' => 'nullable|string',
        ]);

        // Crear el historial laboral asociado al empleo
        $historialLaboral = $empleo->historialLaboral()->create(array_merge($validatedData, [
            'empleado_id' => $empleo->empleado_id // Asegúrate de incluir el ID del empleado
        ]));

        // Redirigir a la vista de empleos con un mensaje de éxito
        return redirect()->route('empleos.index') // Cambia esto si necesitas redirigir a otra ruta
                         ->with('success', 'Historial laboral creado exitosamente.');
    }
}