<?php

namespace App\Http\Controllers;

use App\Models\Barrio;
use App\Models\EstadoIncidencia;
use App\Models\Incidencia;
use App\Models\TipoIncidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidenciaController extends Controller
{
    public function index()
    {
        $incidencias = Incidencia::with(['tipo', 'estado', 'usuario', 'barrio'])
            ->latest()
            ->get();

        return view('incidencias.index', compact('incidencias'));
    }

    public function show(Incidencia $incidencia)
    {
        $incidencia->load(['tipo', 'estado', 'usuario', 'barrio']);

        return view('incidencias.show', compact('incidencia'));
    }

    public function create()
    {
        $tipos = TipoIncidencia::orderBy('nombre')->get();
        $barrios = Barrio::orderBy('nombre')->get();

        return view('incidencias.create', compact('tipos', 'barrios'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:150'],
            'descripcion' => ['required', 'string'],
            'direccion' => ['required', 'string', 'max:255'],
            'codigo_postal' => ['required', 'regex:/^[0-9]{5}$/'],
            'fecha_incidencia' => ['required', 'date'],
            'tipo_incidencia_id' => ['required', 'exists:tipos_incidencia,id'],
            'barrio_id' => ['required', 'exists:barrios,id'],
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
        ]);

        $estadoPendiente = EstadoIncidencia::firstOrCreate([
            'nombre' => 'Pendiente',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('incidencias', 'public');
        }

        Incidencia::create([
            'user_id' => Auth::id(),
            'tipo_incidencia_id' => $datos['tipo_incidencia_id'],
            'estado_incidencia_id' => $estadoPendiente->id,
            'barrio_id' => $datos['barrio_id'],
            'titulo' => $datos['titulo'],
            'descripcion' => $datos['descripcion'],
            'direccion' => $datos['direccion'],
            'codigo_postal' => $datos['codigo_postal'],
            'fecha_incidencia' => $datos['fecha_incidencia'],
            'foto' => $fotoPath,
        ]);

        return redirect()
            ->route('incidencias.mine')
            ->with('success', 'Incidencia registrada correctamente.');
    }

    public function mine()
    {
        $incidencias = Incidencia::with(['tipo', 'estado', 'barrio'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('incidencias.mine', compact('incidencias'));
    }

    public function panelTecnico()
    {
        if (!Auth::user()->esTecnico()) {
            abort(403);
        }

        $incidencias = Incidencia::with(['tipo', 'estado', 'usuario', 'barrio'])
            ->latest()
            ->get();

        $estados = EstadoIncidencia::orderBy('id')->get();

        return view('tecnico.panel', compact('incidencias', 'estados'));
    }

    public function cambiarEstado(Request $request, Incidencia $incidencia)
    {
        if (!Auth::user()->esTecnico()) {
            abort(403);
        }

        $datos = $request->validate([
            'estado_incidencia_id' => ['required', 'exists:estados_incidencia,id'],
        ]);

        $incidencia->update([
            'estado_incidencia_id' => $datos['estado_incidencia_id'],
        ]);

        return redirect()
            ->route('tecnico.panel')
            ->with('success', 'Estado actualizado correctamente.');
    }
}