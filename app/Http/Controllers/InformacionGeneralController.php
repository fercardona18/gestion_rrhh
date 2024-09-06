<?php

namespace App\Http\Controllers;

use App\Models\InformacionGeneral;
use Illuminate\Http\Request;

class InformacionGeneralController extends Controller
{
    public function index()
    {
        $informacion = InformacionGeneral::all();
        return view('informacion.index', compact('informacion'));
    }

    public function create()
    {
        return view('informacion.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'tipo' => 'required|in:responsabilidad,anuncio,informacion_general',
        ]);

        InformacionGeneral::create($request->all());

        return redirect()->route('informacion.index')->with('success', 'Información guardada correctamente.');
    }

    public function edit($id)
    {
        $informacion = InformacionGeneral::findOrFail($id);
        return view('informacion.edit', compact('informacion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'tipo' => 'required|in:responsabilidad,anuncio,informacion_general',
        ]);

        $informacion = InformacionGeneral::findOrFail($id);
        $informacion->update($request->all());

        return redirect()->route('informacion.index')->with('success', 'Información actualizada correctamente.');
    }

    public function destroy($id)
    {
        $informacion = InformacionGeneral::findOrFail($id);
        $informacion->delete();

        return redirect()->route('informacion.index')->with('success', 'Información eliminada correctamente.');
    }
}
