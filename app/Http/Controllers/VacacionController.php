<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Empleado;
use Illuminate\Http\Request;

class VacacionController extends Controller
{
    public function index()
    {
        $vacaciones = Vacacion::with('empleado')->get();
        return view('vacaciones.index', compact('vacaciones'));
    }

    public function create($empleadoId)
    {
        $empleado = Empleado::findOrFail($empleadoId);
        return view('vacaciones.create', compact('empleado'));
    }

    public function store(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'empleado_id' => 'required|exists:empleados,id', // Asegúrate de que el empleado_id sea válido
        'comentarios' => 'nullable|string|max:255', // Validación para comentarios
    ]);

    // Busca el empleado usando el ID enviado en la solicitud
    $empleado = Empleado::findOrFail($request->empleado_id);

    // Crear la solicitud de vacaciones
    Vacacion::create([
        'empleado_id' => $empleado->id,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'estado' => 'pendiente', // Por defecto, el estado será 'pendiente'
        'comentarios' => $request->comentarios, // Guardar comentarios
    ]);

    return redirect()->route('vacaciones.index')->with('success', 'Solicitud de vacaciones enviada.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'estado' => 'required|in:pendiente,autorizado,rechazado',
    ]);

    $vacacion = Vacacion::findOrFail($id);
    $vacacion->estado = $request->estado;
    $vacacion->save();

    return redirect()->route('vacaciones.index')->with('success', 'Estado de la solicitud de vacaciones actualizado.');
}

}