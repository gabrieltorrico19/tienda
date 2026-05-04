<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="c-tienda-main.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="c-tienda-cart.php">Carrito</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="c-checkout.php">Pagar</a>
                </li>
                <?php if (!empty($clienteUsuario)) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../../control/auth/c-logout.php">Salir (<?php echo $clienteUsuario; ?>)</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../auth/c-login.php">Iniciar Sesion</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Carrito de Compras</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cartItems)) { ?>
                        <?php foreach ($cartItems as $item) { ?>
                            <tr>
                                <td><?php echo $item["producto"]["nombre"]; ?></td>
                                <td><?php echo $item["cantidad"]; ?></td>
                                <td>$<?php echo number_format($item["producto"]["precio"], 2); ?></td>
                                <td>$<?php echo number_format($item["subtotal"], 2); ?></td>
                                <td>
                                    <a href="c-tienda-cart.php?accion=eliminar&id=<?php echo $item["producto"]["id_producto"]; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr><td colspan="5" class="text-center">El carrito esta vacio.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <h3 class="text-right">Total: $<?php echo number_format($total, 2); ?></h3>
        <div class="text-right">
            <a href="c-checkout.php" class="btn btn-success">Proceder al Pago</a>
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




