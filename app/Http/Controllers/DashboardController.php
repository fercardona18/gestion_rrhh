<?php

namespace App\Http\Controllers;

use App\Models\InformacionGeneral; 
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtener toda la información general
        $informacionGeneral = InformacionGeneral::all(); // Obtener todas las entradas

        // Filtrar responsabilidades, anuncios e información general
        $responsabilidades = $informacionGeneral->where('tipo', 'responsabilidad');
        $anuncios = $informacionGeneral->where('tipo', 'anuncio');
        $infoGeneral = $informacionGeneral->where('tipo', 'informacion_general');

        // Comprobar si las colecciones están vacías y asignar un mensaje
        if ($responsabilidades->isEmpty()) {
            $responsabilidades = collect(); // Inicializa como colección vacía si no hay datos
        }

        if ($anuncios->isEmpty()) {
            $anuncios = collect(); // Inicializa como colección vacía si no hay datos
        }

        if ($infoGeneral->isEmpty()) {
            $infoGeneral = collect(); // Inicializa como colección vacía si no hay datos
        }

        return view('dashboard.index', compact('responsabilidades', 'anuncios', 'infoGeneral'));
    }
}