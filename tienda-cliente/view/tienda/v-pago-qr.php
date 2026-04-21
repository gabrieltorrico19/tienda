<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago con QR</title>
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
                <li class="nav-item"><a class="nav-link" href="c-home.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="c-cart.php">Carrito</a></li>
                <li class="nav-item"><a class="nav-link" href="c-checkout.php">Pagar</a></li>
                <?php if (!empty($clienteUsuario)) { ?>
                    <li class="nav-item"><a class="nav-link" href="../c-logout.php">Salir (<?php echo $clienteUsuario; ?>)</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="../c-login.php">Iniciar Sesion</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Pago con QR</h2>
        <p class="text-center">Escanea el QR para simular el pago y generar el comprobante.</p>
        <div class="text-center mb-4">
            <img alt="QR de pago" src="<?php echo $baseUrl; ?>/recursos/QR/image.png" style="width:280px;height:280px;object-fit:contain;">
        </div>
        <div class="text-center">
            <a href="c-pago-qr-simular.php?nro=<?php echo $nroVenta; ?>" class="btn btn-success">Simular Pago</a>
            <a href="c-home.php" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
