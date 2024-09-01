<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Empleo;
use Illuminate\Http\Request;

class EmpleoController extends Controller
{
    public function index(Empleado $empleado)
    {
        $empleos = $empleado->empleos;
        return view('empleos.index', compact('empleados', 'empleo')); // Asegúrate de pasar el empleado
    }

    public function create(Empleado $empleado)
    {
        return view('empleos.create', compact('empleado'));
    }

    public function store(Request $request, Empleado $empleado)
    {
        $validatedData = $request->validate([
            'fecha_ingreso' => 'required|date',
            'puesto' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
            'tipo_contrato' => 'required|string|max:50',
            'salario_base' => 'required|numeric',
        ]);

        $empleo = $empleado->empleos()->create($validatedData);

        return redirect()->route('empleos.index', $empleado->id)
                         ->with('success', 'Empleo creado exitosamente.');
    }

    public function edit(Empleo $empleo)
    {
        return view('empleos.edit', compact('empleo'));
    }

    public function update(Request $request, Empleo $empleo)
    {
        $validatedData = $request->validate([
            'fecha_ingreso' => 'required|date',
            'puesto' => 'required|string|max:100',
            'departamento' => 'required|string|max:100',
            'tipo_contrato' => 'required|string|max:50',
            'salario_base' => 'required|numeric',
        ]);

        $empleo->update($validatedData);

        return redirect()->route('empleos.index', $empleo->empleado_id)
                         ->with('success', 'Empleo actualizado exitosamente.');
    }

    public function destroy(Empleo $empleo)
    {
        $empleadoId = $empleo->empleado_id; // Guardamos el ID del empleado antes de eliminar
        $empleo->delete();

        return redirect()->route('empleos.index', $empleadoId)
                         ->with('success', 'Empleo eliminado exitosamente.');
    }
}