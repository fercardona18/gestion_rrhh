<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    // Muestra la lista de empleados
    public function index()
    {
        $empleados = Empleado::with('empleos')->get(); // Carga empleados con sus empleos
        return view('empleados.index', compact('empleados'));
    }

    // Muestra el formulario para agregar un nuevo empleado
    public function create()
    {
        return view('empleados.create');
    }

    // Almacena un nuevo empleado en la base de datos
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:empleados|max:255',
            'fecha_nacimiento' => 'required|date',
            'estado_civil' => 'required|string|max:50',
            'fecha_ingreso' => 'required|date',
            'puesto' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'tipo_contrato' => 'nullable|string|max:50',
            'salario_base' => 'nullable|numeric',
            'experiencia_previa' => 'nullable|string',
            'educacion' => 'nullable|string',
            'certificaciones' => 'nullable|string',
        ]);
    
        // Crea el nuevo empleado
        $empleado = Empleado::create($validatedData);
    
        // Si se proporcionó información de empleo, crea el registro de empleo
        if ($request->filled('puesto')) {
            $empleado->empleos()->create([
                'fecha_ingreso' => $request->fecha_ingreso,
                'puesto' => $request->puesto,
                'departamento' => $request->departamento,
                'tipo_contrato' => $request->tipo_contrato,
                'salario_base' => $request->salario_base,
            ]);
        }
    
        // Si se proporcionó información de historial laboral, crea el registro de historial
        if ($request->filled('experiencia_previa') || $request->filled('educacion') || $request->filled('certificaciones')) {
            $empleado->historialLaboral()->create([
                'experiencia_previa' => $request->experiencia_previa,
                'educacion' => $request->educacion,
                'certificaciones' => $request->certificaciones,
            ]);
        }
    
        return redirect()->route('empleados.index')
                         ->with('success', 'Empleado creado exitosamente.');
    }

    // Muestra los detalles de un empleado específico
    public function show(Empleado $empleado)
{
    // Carga los empleos y el historial laboral del empleado
    $empleado->load('empleos', 'historialLaboral');
    return view('empleados.show', compact('empleado'));
}

    // Muestra el formulario para editar un empleado existente
    public function edit(Empleado $empleado)
    {
        return view('empleados.edit', compact('empleado'));
    }

    // Actualiza la información de un empleado en la base de datos
    public function update(Request $request, Empleado $empleado)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:empleados,email,' . $empleado->id . '|max:255',
            'fecha_nacimiento' => 'required|date',
            'estado_civil' => 'required|string|max:50',
            'fecha_ingreso' => 'required|date',
        ]);

        $empleado->update($validatedData); // Actualiza el empleado

        return redirect()->route('empleados.index')
                         ->with('success', 'Empleado actualizado exitosamente.');
    }

    // Elimina un empleado de la base de datos
    public function destroy(Empleado $empleado)
    {
        $empleado->delete(); // Elimina el empleado

        return redirect()->route('empleados.index')
                         ->with('success', 'Empleado eliminado exitosamente.');
    }
}