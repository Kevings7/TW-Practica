@extends('layouts.app')

@section('title', 'Contacto')

@section('content')
<section class="contact-page">
    <div class="contact-hero">
        <span class="contact-badge">Información del proyecto</span>
        <h2>Contacto</h2>
        <p>
            Página informativa del proyecto de Gestión de Incidencias Urbanas.
        </p>
    </div>

    <div class="contact-grid">
        <article class="contact-card">
            <div class="contact-icon">🏛️</div>
            <h3>Proyecto</h3>
            <p>Gestión de Incidencias Urbanas</p>
        </article>

        <article class="contact-card">
            <div class="contact-icon">💻</div>
            <h3>Asignatura</h3>
            <p>Tecnologías Web</p>
        </article>

        <article class="contact-card">
            <div class="contact-icon">👥</div>
            <h3>Grupo</h3>
            <p>Grupo 6</p>
        </article>
    </div>
</section>
@endsection