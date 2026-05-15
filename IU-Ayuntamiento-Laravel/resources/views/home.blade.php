@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="row">

    <aside class="col-md-3 mb-4">
        <div class="list-group shadow-sm">
            <h5 class="list-group-item list-group-item-dark mb-0">Categorías</h5>
            <a href="{{ route('incidencias.index') }}" class="list-group-item list-group-item-action">📍 Todas</a>

            @foreach($categorias as $categoria)
                <a href="{{ route('incidencias.index') }}" class="list-group-item list-group-item-action">
                    {{ $categoria->nombre }}
                </a>
            @endforeach
        </div>
    </aside>

    <section class="col-md-9">
    <div class="jumbotron-custom">
        <h2>Servicio de Atención Ciudadana</h2>
        <p>Colabora con el Ayuntamiento para mantener una Granada limpia, segura y cuidada.</p>
    </div>

        <h2 class="mb-4">Estado de Incidencias Recientes</h2>
        <div class="row row-cols-1 g-4">
            @forelse($incidencias as $incidencia)
                <div class="col">
                    <div class="card h-100 shadow-sm border-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title">{{ $incidencia->titulo }}</h5>
                                <span class="badge bg-warning text-dark">{{ $incidencia->estado->nombre }}</span>
                            </div>

                            <p class="card-text text-muted">📍 {{ $incidencia->direccion }}</p>
                            <p class="card-text">
                                <strong>Categoría:</strong> {{ $incidencia->tipo->nombre }}
                            </p>

                            <a href="{{ route('incidencias.show', $incidencia) }}" class="btn btn-outline-primary btn-sm">
                                Ver detalle
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No hay incidencias registradas.</p>
            @endforelse
        </div>
    </section>

</div>
@endsection