<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    // Muestra todas las notificaciones del usuario logueado
    public function index()
    {
        $notificaciones = Notificacion::where('usuario_id', Auth::id())
            ->latest()
            ->get();

        // Contamos las no leídas para mostrar el número en la vista
        $totalNoLeidas = $notificaciones->where('leida', false)->count();

        return view('notificaciones.index', compact('notificaciones', 'totalNoLeidas'));
    }

    // Marca todas las notificaciones del usuario como leídas
    public function marcarTodasLeidas()
    {
        Notificacion::where('usuario_id', Auth::id())
            ->where('leida', false)
            ->update(['leida' => true]);

        return redirect()->route('notificaciones.index')->with('success', 'Todas las notificaciones marcadas como leídas.');
    }

    // Marca una sola notificación como leída y redirige a la incidencia si tiene
    public function marcarLeida(Notificacion $notificacion)
    {
        // Seguridad: solo el dueño puede marcarla
        if ($notificacion->usuario_id !== Auth::id()) {
            abort(403);
        }

        $notificacion->update(['leida' => true]);

        // Si tiene incidencia, vamos a ella; si no, volvemos a notificaciones
        if ($notificacion->incidencia_id) {
            return redirect()->route('incidencias.show', $notificacion->incidencia_id);
        }

        return redirect()->route('notificaciones.index');
    }
}
