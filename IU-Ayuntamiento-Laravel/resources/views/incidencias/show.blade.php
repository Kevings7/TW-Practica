@extends('layouts.app')

@section('title', 'Detalle de incidencia')

@section('content')
    <h2 class="mb-4">Detalle de incidencia</h2>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">{{ $incidencia->titulo }}</h4>

            <span class="badge {{ $incidencia->estado->nombre === 'Solucionado' ? 'bg-success' : 'bg-warning text-dark' }}">
                {{ $incidencia->estado->nombre }}
            </span>
        </div>

        <div class="card-body">
            <p>
                <strong>Descripción:</strong>
                {{ $incidencia->descripcion }}
            </p>

            <p>
                <strong>Dirección:</strong>
                {{ $incidencia->direccion }}
            </p>

            @if($incidencia->barrio)
                <p>
                    <strong>Barrio:</strong>
                    {{ $incidencia->barrio->nombre }}
                </p>
            @endif

            @if($incidencia->codigo_postal)
                <p>
                    <strong>Código postal:</strong>
                    {{ $incidencia->codigo_postal }}
                </p>
            @endif

            <p>
                <strong>Categoría:</strong>
                {{ $incidencia->tipo->nombre }}
            </p>

            <p>
                <strong>Estado:</strong>
                {{ $incidencia->estado->nombre }}
            </p>

            @if($incidencia->fecha_incidencia)
                <p>
                    <strong>Fecha de la incidencia:</strong>
                    {{ \Carbon\Carbon::parse($incidencia->fecha_incidencia)->format('d/m/Y') }}
                </p>
            @endif

            <p>
                <strong>Reportada por:</strong>
                {{ $incidencia->usuario->name }} {{ $incidencia->usuario->apellidos }}
            </p>

            <p>
                <strong>Fecha de registro:</strong>
                {{ $incidencia->created_at->format('d/m/Y H:i') }}
            </p>

            @if($incidencia->foto)
                <div class="mb-3">
                    <strong>Fotografía:</strong><br>

                    <img
                        src="{{ asset('storage/' . $incidencia->foto) }}"
                        alt="Fotografía de la incidencia"
                        class="img-fluid rounded mt-2"
                        style="max-width: 400px;"
                    >
                </div>
            @endif

            <a href="{{ route('incidencias.index') }}" class="btn btn-secondary">
                Volver al listado
            </a>

            @auth
                @if(auth()->id() === $incidencia->user_id)
                    <a href="{{ route('incidencias.mine') }}" class="btn btn-outline-primary">
                        Volver a mis incidencias
                    </a>
                @endif

                @if(auth()->user()->esTecnico())
                    <a href="{{ route('tecnico.panel') }}" class="btn btn-outline-dark">
                        Volver al panel técnico
                    </a>
                @endif
            @endauth
        </div>
    </div>
@endsection