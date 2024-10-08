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
            'dpi' => 'required|string|unique:empleados,dpi|max:13', 
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:empleados,email',
            'fecha_nacimiento' => 'required|date',
            'estado_civil' => 'required|string|max:50',
            'fecha_ingreso' => 'required|date',
            'dias_vacaciones_disponibles' => 'required|integer|min:0',
            'password' => 'required|string|min:8', // Asegúrate de que la contraseña sea segura
        ]);
    
        // Crea el nuevo empleado sin encriptar la contraseña
        $empleado = Empleado::create([
            'name' => $validatedData['name'],
            'dpi' => $validatedData['dpi'],
            'direccion' => $validatedData['direccion'],
            'telefono' => $validatedData['telefono'],
            'email' => $validatedData['email'],
            'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
            'estado_civil' => $validatedData['estado_civil'],
            'fecha_ingreso' => $validatedData['fecha_ingreso'],
            'dias_vacaciones_disponibles' => $validatedData['dias_vacaciones_disponibles'],
            // Almacena la contraseña directamente sin hash
            'password' => $validatedData['password'], 
        ]);
    
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
    public function update(Request $request, $id)
    {
        // Buscar el empleado por ID
        $empleado = Empleado::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'dpi' => 'required|string|unique:empleados,dpi,'.$empleado->id.'|max:13', 
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:empleados,email,'.$empleado->id,
            'fecha_nacimiento' => 'required|date',
            'estado_civil' => 'required|string|max:50',
            'dias_vacaciones_disponibles' => 'required|integer|min:0',
            'fecha_ingreso' => 'required|date',
            // Otros campos según sea necesario...
        ]);

        // Actualiza el empleado sin cambiar la contraseña si no se proporciona una nueva
        if ($request->filled('password')) {
            // Solo actualizar la contraseña si se proporciona una nueva
            $validatedData['password'] = $request->password; 
        }

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