<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Exitosa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="c-home.php">
            <img src="https://getbootstrap.com/docs/4.5/assets/brand/bootstrap-solid.svg" width="30" height="30" alt="Logo" class="d-inline-block align-top">
            <?php echo $appTitle; ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="c-home.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="c-cart.php">Carrito</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="c-checkout.php">Pagar</a>
                </li>
                <?php if (!empty($clienteUsuario)) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../c-logout.php">Salir (<?php echo $clienteUsuario; ?>)</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../c-login.php">Iniciar Sesion</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="alert alert-success text-center">
            <h1>Gracias por tu compra</h1>
            <p>Tu pedido ha sido procesado exitosamente. Pronto recibiras un correo con los detalles de tu pedido.</p>
            <a href="c-home.php" class="btn btn-primary mt-3">Volver al Inicio</a>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-1">&copy; <?php echo date("Y"); ?> <?php echo $appTitle; ?>. Todos los derechos reservados.</p>
            <div class="d-flex justify-content-center">
                <a href="https://www.facebook.com" target="_blank" class="text-white mx-2">Facebook</a>
                <a href="https://www.twitter.com" target="_blank" class="text-white mx-2">Twitter</a>
                <a href="https://www.instagram.com" target="_blank" class="text-white mx-2">Instagram</a>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
