<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto');
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'asunto' => ['required', 'string', 'max:150'],
            'mensaje' => ['required', 'string'],
        ]);

        return redirect()
            ->route('contacto')
            ->with('enviado', true);
    }
}