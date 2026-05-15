@extends('layouts.app')

@section('title', 'Panel técnico')

@section('content')
    <h2 class="mb-4">Panel técnico</h2>

    @if($incidencias->isEmpty())
        <p>No hay incidencias registradas.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Dirección</th>
                        <th>Barrio</th>
                        <th>Tipo</th>
                        <th>Usuario</th>
                        <th>Estado actual</th>
                        <th>Cambiar estado</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($incidencias as $incidencia)
                        <tr>
                            <td>
                                <a href="{{ route('incidencias.show', $incidencia) }}">
                                    {{ $incidencia->titulo }}
                                </a>
                            </td>

                            <td>
                                {{ $incidencia->direccion }}

                                @if($incidencia->codigo_postal)
                                    <br>
                                    <small class="text-muted">
                                        CP: {{ $incidencia->codigo_postal }}
                                    </small>
                                @endif
                            </td>

                            <td>
                                @if($incidencia->barrio)
                                    {{ $incidencia->barrio->nombre }}
                                @else
                                    <span class="text-muted">Sin barrio</span>
                                @endif
                            </td>

                            <td>
                                {{ $incidencia->tipo->nombre }}
                            </td>

                            <td>
                                {{ $incidencia->usuario->name }} {{ $incidencia->usuario->apellidos }}
                            </td>

                            <td>
                                <span class="badge bg-warning text-dark">
                                    {{ $incidencia->estado->nombre }}
                                </span>
                            </td>

                            <td>
                                <form action="{{ route('tecnico.estado', $incidencia) }}" method="POST">
                                    @csrf

                                    <div class="d-flex gap-2">
                                        <select name="estado_incidencia_id" class="form-select form-select-sm" required>
                                            @foreach($estados as $estado)
                                                <option
                                                    value="{{ $estado->id }}"
                                                    @selected($incidencia->estado_incidencia_id == $estado->id)
                                                >
                                                    {{ $estado->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Guardar
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection