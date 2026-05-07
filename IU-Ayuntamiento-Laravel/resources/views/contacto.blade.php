@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2 class="mb-0">Contacto con el Ayuntamiento</h2>
        </div>

        <div class="card-body">
            <p>
                Desde esta página se podrá contactar con el Ayuntamiento para realizar
                consultas relacionadas con incidencias urbanas.
            </p>

            <div class="alert alert-warning">
                Actualmente estás accediendo como usuario no identificado.
                Cuando se añada el sistema de inicio de sesión, este formulario estará
                disponible solo para usuarios registrados.
            </div>

            <form action="#" method="post" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label for="asunto" class="form-label">Asunto de la consulta:</label>
                    <input type="text" id="asunto" name="asunto" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" class="form-control" rows="5" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Enviar mensaje</button>
            </form>
        </div>
    </div>
@endsection