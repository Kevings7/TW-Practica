<?php include 'includes/header.php'; ?>

<main class="container my-5">
    <?php if (isset($_COOKIE['usuario'])): ?>
        <h2>Formulario de Contacto para Ciudadanos</h2>
        <p>Bienvenido, <strong><?php echo htmlspecialchars($_COOKIE['usuario']); ?></strong>. Puede enviarnos su consulta técnica a continuación.</p>

        <form action="enviar_consulta.php" method="post" class="mt-4">
            <div class="mb-3">
                <label for="asunto" class="form-label">Asunto de la consulta:</label>
                <input type="text" id="asunto" name="asunto" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="mensaje" class="form-label">Mensaje:</label>
                <textarea id="mensaje" name="mensaje" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Enviar mensaje</button>
        </form>

    <?php else: ?>
        <div class="alert alert-warning text-center">
            <h2>Acceso Restringido</h2>
            <p>Para poder contactar con el Ayuntamiento, debe estar identificado en el sistema.</p>
            <a href="login.php" class="btn btn-primary mt-3">Ir al inicio de sesión</a>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>