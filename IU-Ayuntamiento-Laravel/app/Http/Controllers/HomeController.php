<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use App\Models\TipoIncidencia;

class HomeController extends Controller
{
    public function index()
    {
        $categorias = TipoIncidencia::orderBy('nombre')->get();

        $incidencias = Incidencia::with(['tipo', 'estado'])
            ->latest()
            ->take(5)
            ->get();

        return view('home', compact('categorias', 'incidencias'));
    }

    public function contacto()
    {
        return view('contacto');
    }
}