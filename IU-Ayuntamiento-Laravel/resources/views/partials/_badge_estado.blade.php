{{-- Partial: _badge_estado.blade.php
     Uso: @include('partials._badge_estado', ['estado' => $incidencia->estado->nombre])
--}}
@php
    $clases = [
        'Pendiente'   => 'bg-secondary',
        'Validada'    => 'bg-info text-dark',
        'En proceso'  => 'bg-warning text-dark',
        'Solucionado' => 'bg-success',
        'Rechazada'   => 'bg-danger',
    ];
    $clase = $clases[$estado] ?? 'bg-secondary';
@endphp
<span class="badge {{ $clase }}">{{ $estado }}</span>
