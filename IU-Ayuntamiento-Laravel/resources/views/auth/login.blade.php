@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h2 class="mb-4">Iniciar sesión</h2>

    <form action="{{ route('login.post') }}" method="POST" class="card card-body shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>
@endsection
