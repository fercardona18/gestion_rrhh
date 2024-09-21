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
        // Encuentra el empleo relacionado si es necesario
    $empleo = Empleo::where('empleado_id', $empleadoId)->first();
    return view('nomina.create', compact('empleado','empleo'));
    }

   // Almacena una nueva nómina en la base de datos
   public function store(Request $request, $empleadoId)
   {
       // Validar los datos del formulario
       $validatedData = $request->validate([
           'horas_extras' => 'nullable|numeric|min:0',
           'prestaciones' => 'nullable|numeric|min:0',
           'empleo_id' => 'required|exists:empleos,id', // Asegúrate de validar empleo_id
       ]);
   
       // Encuentra el empleado relacionado
       $empleado = Empleado::findOrFail($empleadoId);
   
       // Encuentra el empleo relacionado
       $empleo = Empleo::findOrFail($validatedData['empleo_id']); // Obtener el empleo usando el empleo_id
   
       // Calcular salario base, deducciones y bonificación
       $salario_base = $empleo->salario_base; // Tomar el salario base del empleo
       if (is_null($salario_base)) {
           return redirect()->back()->withErrors(['salario_base' => 'El salario base no puede ser nulo.']);
       }
   
       $deducciones = $salario_base * 0.1267; // 12.67% del salario base
       $bonificacion = 250;
   
       // Calcular total a pagar
       $horas_extras = $validatedData['horas_extras'] ?? 0;
       $total_a_pagar = $salario_base + ($horas_extras * ($salario_base / 240)) + $bonificacion - $deducciones + ($validatedData['prestaciones'] ?? 0);
   
       // Crea la nómina asociada al empleado
       Nomina::create([
           'salario_base' => $salario_base,
           'horas_extras' => $horas_extras,
           'deducciones' => $deducciones,
           'bonificaciones' => $bonificacion,
           'prestaciones' => $validatedData['prestaciones'] ?? 0,
           'empleado_id' => $empleado->id,
           'empleo_id' => $validatedData['empleo_id'],
           'total_a_pagar' => $total_a_pagar, // Almacena el total a pagar si es necesario
       ]);
   
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