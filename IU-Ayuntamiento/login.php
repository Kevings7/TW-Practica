<?php include 'includes/header.php'; ?>

<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="text-center mb-4">Acceso al Portal</h2>
                    
                    <form action="register.php" method="post">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre de usuario:</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico:</label>
                            <input type="email" id="email" name="email" class="form-control" 
                                   placeholder="ejemplo@correo.com" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" id="novedades" name="novedades" class="form-check-input" checked>
                            <label for="novedades" class="form-check-label">Recordar mi sesión</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>