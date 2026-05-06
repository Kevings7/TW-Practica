<?php include('includes/header.php'); ?>

<div class="container my-4">
  <div class="row">
    
    <!-- MENÚ LATERAL[cite: 1] -->
    <aside class="col-md-3 mb-4">
      <div class="list-group shadow-sm">
        <h5 class="list-group-item list-group-item-dark mb-0">Categorías</h5>
        <button type="button" class="list-group-item list-group-item-action">📍 Todas</button>
        <button type="button" class="list-group-item list-group-item-action">💡 Alumbrado</button>
        <button type="button" class="list-group-item list-group-item-action">🧹 Limpieza</button>
        <button type="button" class="list-group-item list-group-item-action">🚧 Vía Pública</button>
      </div>
    </aside>

    <!-- ZONA CENTRAL DE CONTENIDO[cite: 1] -->
    <main class="col-md-9">
      <h2 class="mb-4">Estado de Incidencias Recientes</h2>
      
      <div class="row row-cols-1 g-4">
        <!-- Ejemplo de Incidencia (Vista Pública)[cite: 1] -->
        <div class="col">
          <div class="card h-100 shadow-sm border-warning">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <h5 class="card-title">Aviso de Iluminación</h5>
                <span class="badge bg-warning text-dark">En proceso</span> <!-- Estado requerido[cite: 1] -->
              </div>
              <p class="card-text text-muted">📍 Calle Mayor, 10</p>
              <a href="detalle.php" class="btn btn-outline-primary btn-sm">Ver detalle</a>
            </div>
          </div>
        </div>
      </div>
    </main>

  </div>
</div>

<?php include('includes/footer.php'); ?>