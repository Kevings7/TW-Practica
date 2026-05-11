@extends('layouts.app')

@section('title', 'Reportar incidencia')

@section('content')
    <h2 class="mb-4">Reportar nueva incidencia</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Hay errores en el formulario.</strong>
        </div>
    @endif

    <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data" class="card card-body shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="titulo" class="form-label">Título de la incidencia</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}" required>
            @error('titulo') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required>{{ old('descripcion') }}</textarea>
            @error('descripcion') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="tipo_incidencia_id" class="form-label">Tipo de incidencia</label>
            <select name="tipo_incidencia_id" id="tipo_incidencia_id" class="form-select" required>
                <option value="">Seleccione un tipo</option>

                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" @selected(old('tipo_incidencia_id') == $tipo->id)>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>
            @error('tipo_incidencia_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="barrio_id" class="form-label">Barrio o zona</label>
            <select name="barrio_id" id="barrio_id" class="form-select" required>
                <option value="">Seleccione un barrio</option>

                @foreach($barrios as $barrio)
                    <option value="{{ $barrio->id }}" @selected(old('barrio_id') == $barrio->id)>
                        {{ $barrio->nombre }}
                    </option>
                @endforeach
            </select>
            @error('barrio_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}" required>
            @error('direccion') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="codigo_postal" class="form-label">Código postal</label>
            <input type="text" name="codigo_postal" id="codigo_postal" class="form-control" value="{{ old('codigo_postal') }}" pattern="[0-9]{5}" required>
            @error('codigo_postal') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="fecha_incidencia" class="form-label">Fecha de la incidencia</label>
            <input type="date" name="fecha_incidencia" id="fecha_incidencia" class="form-control" value="{{ old('fecha_incidencia') }}" required>
            @error('fecha_incidencia') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Fotografía de la incidencia</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/jpeg,image/png,image/webp" required>
            @error('foto') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            Enviar incidencia
        </button>
    </form>
@endsection