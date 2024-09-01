<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Empleo;
use App\Models\Nomina;
use Illuminate\Http\Request;

class NominaController extends Controller
{
    // Muestra la lista de nóminas para un empleo específico
    public function index()
{
    $nominas = Nomina::with('empleado')->get(); // Cargar las nóminas con la relación de empleado
    return view('nomina.index', compact('nominas'));
}

    // Muestra el formulario para crear una nueva nómina
    public function create($empleadoId)
    {
        $empleado = Empleado::findOrFail($empleadoId);
        return view('nomina.create', compact('empleado'));
    }

    // Almacena una nueva nómina en la base de datos
    public function store(Request $request, $empleadoId)
{
    $validatedData = $request->validate([
        'salario_base' => 'required|numeric',
        'horas_extras' => 'nullable|numeric',
        'deducciones' => 'nullable|numeric',
        'bonificaciones' => 'nullable|numeric',
        'prestaciones' => 'nullable|numeric',
    ]);

    // Encuentra el empleado relacionado
    $empleado = Empleado::findOrFail($empleadoId);

    // Crea la nómina asociada al empleado
    $nomina = $empleado->nomina()->create(array_merge($validatedData, ['empleado_id' => $empleado->id]));

    return redirect()->route('nomina.index', $empleado->id)
                     ->with('success', 'Nómina creada exitosamente.');
}

    // Muestra el formulario para editar una nómina existente
    public function edit(Nomina $nomina)
    {
        $empleo = $nomina->empleo; // Obtiene el empleo relacionado con la nómina
        return view('nomina.edit', compact('nomina', 'empleo'));
    }

    // Actualiza la nómina en la base de datos
    public function update(Request $request, Nomina $nomina)
    {
        $validatedData = $request->validate([
            'salario_base' => 'required|numeric',
            'horas_extras' => 'nullable|numeric',
            'deducciones' => 'nullable|numeric',
            'bonificaciones' => 'nullable|numeric',
            'prestaciones' => 'nullable|numeric',
        ]);

        $nomina->update($validatedData); // Actualiza la nómina

        return redirect()->route('nomina.index', $nomina->empleo_id)
                         ->with('success', 'Nómina actualizada exitosamente.');
    }

    // Elimina una nómina de la base de datos
    public function destroy(Nomina $nomina)
    {
        $empleoId = $nomina->empleo_id; // Guardamos el ID del empleo antes de eliminar
        $nomina->delete(); // Elimina la nómina

        return redirect()->route('nomina.index', $empleoId)
                         ->with('success', 'Nómina eliminada exitosamente.');
    }
}