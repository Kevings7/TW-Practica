@extends('layouts.app')

@section('title', 'Mis notificaciones')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">
        Mis notificaciones
        @if($totalNoLeidas > 0)
            <span class="badge bg-danger ms-2">{{ $totalNoLeidas }} nuevas</span>
        @endif
    </h2>

    @if($totalNoLeidas > 0)
        <form action="{{ route('notificaciones.marcarTodas') }}" method="POST">
            @csrf
            <button class="btn btn-outline-secondary btn-sm" type="submit">
                ✓ Marcar todas como leídas
            </button>
        </form>
    @endif
</div>

@if($notificaciones->isEmpty())
    <div class="alert alert-info">
        No tienes notificaciones todavía. Cuando el Ayuntamiento actualice el estado de alguna de tus incidencias, te avisaremos aquí.
    </div>
@else
    <div class="list-group shadow-sm">
        @foreach($notificaciones as $notificacion)
            <div class="list-group-item {{ $notificacion->leida ? '' : 'list-group-item-warning' }}">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        @if(!$notificacion->leida)
                            <span class="badge bg-danger me-1">Nueva</span>
                        @endif
                        <strong>{{ $notificacion->titulo }}</strong>
                        <p class="mb-1 text-muted small">{{ $notificacion->mensaje }}</p>
                        <small class="text-muted">{{ $notificacion->created_at->format('d/m/Y H:i') }}</small>
                    </div>

                    <div class="ms-3 flex-shrink-0">
                        {{-- Solo mostramos el botón si no está leída o tiene incidencia --}}
                        @if($notificacion->incidencia_id || !$notificacion->leida)
                            <form action="{{ route('notificaciones.leer', $notificacion) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $notificacion->incidencia_id ? 'btn-outline-primary' : 'btn-outline-secondary' }}">
                                    {{ $notificacion->incidencia_id ? 'Ver incidencia' : 'Marcar leída' }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection
