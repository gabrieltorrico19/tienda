<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simular Pago QR</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/view/css/main.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="c-tienda-main.php">
            <img src="https://getbootstrap.com/docs/4.5/assets/brand/bootstrap-solid.svg" width="30" height="30" alt="Logo" class="d-inline-block align-top">
            <?php echo $appTitle; ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="c-tienda-main.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="c-tienda-cart.php">Carrito</a></li>
                <li class="nav-item"><a class="nav-link" href="c-checkout.php">Pagar</a></li>
                <?php if (!empty($clienteUsuario)) { ?>
                    <li class="nav-item"><a class="nav-link" href="../../control/auth/c-logout.php">Salir (<?php echo $clienteUsuario; ?>)</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="../auth/c-login.php">Iniciar Sesion</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Simulacion de Pago</h2>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Resumen de la venta</h5>
                <ul class="list-group list-group-flush">
                    <?php foreach ($items as $item) { ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo $item["nombre"]; ?> x <?php echo $item["cantidad"]; ?>
                            <span>$<?php echo number_format($item["subtotal"], 2); ?></span>
                        </li>
                    <?php } ?>
                </ul>
                <div class="text-right mt-3">
                    <strong>Total: $<?php echo number_format($nota->totalVenta, 2); ?></strong>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="c-comprobante-pdf.php?nro=<?php echo $nota->nro; ?>" class="btn btn-success">Generar Comprobante PDF</a>
            <a href="c-tienda-main.php" class="btn btn-secondary">Finalizar</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




