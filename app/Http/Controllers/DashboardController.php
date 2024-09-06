<?php

namespace App\Http\Controllers;

use App\Models\InformacionGeneral; 
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Obtener toda la información general
        $informacionGeneral = InformacionGeneral::all(); // Obtener todas las entradas

        // Filtrar responsabilidades, anuncios e información general
        $responsabilidades = $informacionGeneral->where('tipo', 'responsabilidad');
        $infoGeneral = $informacionGeneral->where('tipo', 'informacion_general');
        $anuncios = $informacionGeneral->where('tipo', 'anuncio');

        // Inicializar la variable $fecha
        $fecha = null;

        // Filtrar según la fecha si se proporciona una fecha
        if ($request->has('fecha')) {
            $fecha = $request->input('fecha');

            // Filtrar responsabilidades por fecha
            $responsabilidades = $responsabilidades->filter(function ($responsabilidad) use ($fecha) {
                return \Carbon\Carbon::parse($responsabilidad->created_at)->isSameDay(\Carbon\Carbon::parse($fecha));
            });

            // Filtrar información general por fecha
            $infoGeneral = $infoGeneral->filter(function ($info) use ($fecha) {
                return \Carbon\Carbon::parse($info->created_at)->isSameDay(\Carbon\Carbon::parse($fecha));
            });

            // Filtrar anuncios por fecha
            $anuncios = $anuncios->filter(function ($anuncio) use ($fecha) {
                return \Carbon\Carbon::parse($anuncio->created_at)->isSameDay(\Carbon\Carbon::parse($fecha));
            });
        }

        return view('dashboard', compact('responsabilidades', 'anuncios', 'infoGeneral', 'fecha'));
    }
}