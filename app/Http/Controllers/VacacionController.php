<?php

namespace App\Http\Controllers;

use App\Models\Vacacion;
use App\Models\Empleado;
use Illuminate\Http\Request;

class VacacionController extends Controller
{
    public function index()
    {
        // Mostrar todas las solicitudes de vacaciones
        $vacaciones = Vacacion::with('empleado')->get();
        return view('vacaciones.index', compact('vacaciones'));
    }

    public function create($empleado_id)
    {
       
        $empleado = Empleado::findOrFail($empleado_id); // Busca el empleado por ID
        return view('vacaciones.create', compact('empleado'));

    }

    public function store(Request $request)
    {
        // Validar y guardar la solicitud de vacaciones
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'dias_solicitados' => 'required|integer',
            'comentario' => 'nullable|string',
        ]);

        Vacacion::create($request->all());

        return redirect()->route('vacaciones.index')->with('success', 'Solicitud de vacaciones creada exitosamente.');
    }

    // Métodos para aprobar/rechazar solicitudes...
    public function approve($id)
    {
        $vacacion = Vacacion::findOrFail($id);
    $empleado = $vacacion->empleado;

    // Descontar los días de vacaciones del saldo disponible del empleado
    $empleado->dias_vacaciones_disponibles -= $vacacion->dias_solicitados;
    $empleado->save();

    $vacacion->estado = 'aprobado';
    $vacacion->save();

    return redirect()->route('vacaciones.index')->with('success', 'Solicitud de vacaciones aprobada.');
    }

    public function reject($id, Request $request)
    {
        $vacacion = Vacacion::findOrFail($id);
        $vacacion->estado = 'rechazado';
        $vacacion->comentario = $request->comentario; // Guardar el comentario de rechazo
        $vacacion->save();

        return redirect()->route('vacaciones.index')->with('success', 'Solicitud de vacaciones rechazada.');
    }

}