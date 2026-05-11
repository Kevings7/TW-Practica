@extends('layouts.app')

@section('title', 'Incidencias')

@section('content')
    <h2 class="mb-4">Listado Público de Incidencias</h2>

    <div class="row row-cols-1 g-4">
        @forelse($incidencias as $incidencia)
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title">{{ $incidencia->titulo }}</h5>

                                <p class="card-text text-muted mb-1">
                                    📍 {{ $incidencia->direccion }}
                                </p>

                                @if($incidencia->barrio)
                                    <p class="card-text text-muted mb-1">
                                        <strong>Barrio:</strong> {{ $incidencia->barrio->nombre }}
                                    </p>
                                @endif

                                @if($incidencia->codigo_postal)
                                    <p class="card-text text-muted mb-1">
                                        <strong>Código postal:</strong> {{ $incidencia->codigo_postal }}
                                    </p>
                                @endif

                                <p class="card-text mt-2">
                                    {{ $incidencia->descripcion }}
                                </p>

                                <p class="card-text">
                                    <strong>Categoría:</strong> {{ $incidencia->tipo->nombre }}
                                </p>

                                @if($incidencia->fecha_incidencia)
                                    <p class="card-text">
                                        <strong>Fecha de la incidencia:</strong>
                                        {{ \Carbon\Carbon::parse($incidencia->fecha_incidencia)->format('d/m/Y') }}
                                    </p>
                                @endif

                                <a href="{{ route('incidencias.show', $incidencia) }}" class="btn btn-outline-primary btn-sm">
                                    Ver detalle
                                </a>
                            </div>

                            <span class="badge bg-warning text-dark">
                                {{ $incidencia->estado->nombre }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <p>No hay incidencias registradas.</p>
        @endforelse
    </div>
@endsection