<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestión de Incidencias - Ayuntamiento')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>

<header class="container py-4">
    <h1 class="text-center">Gestión de Incidencias Urbanas</h1>

    <nav class="navbar navbar-expand-md bg-body-tertiary border-top border-bottom">
        <div class="container-fluid">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Vista Pública</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('incidencias.index') }}">Incidencias</a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('incidencias.create') }}">Reportar Incidencia</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('incidencias.mine') }}">Mis incidencias</a>
                    </li>

                    @if(auth()->user()->esTecnico())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('tecnico.panel') }}">Panel Técnico</a>
                        </li>
                    @endif
                @endauth

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contacto') }}">Contacto</a>
                </li>
            </ul>

            <div class="navbar-nav ms-auto align-items-center">
                @guest
                    <span class="navbar-text me-3">Usuario no identificado</span>
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="nav-link" href="{{ route('register') }}">Registro</a>
                @else
                    <span class="navbar-text me-3">
                        {{ auth()->user()->name }} - {{ auth()->user()->role->nombre }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm" type="submit">Cerrar sesión</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>
</header>

<main class="container my-4">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

<footer class="container text-center py-4 border-top">
    <p>&copy; 2026 - Grupo 6</p>
    <p>
        <a href="{{ route('contacto') }}">Contacto</a>
        |
        <a href="{{ asset('como_se_hizo.pdf') }}" target="_blank">como_se_hizo.pdf</a>
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>