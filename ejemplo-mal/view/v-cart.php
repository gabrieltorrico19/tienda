<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../recursos/css/estilos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include __DIR__ . "/partials/encabezado.php"; ?>

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
                                    <a href="c-cart.php?accion=eliminar&id=<?php echo $item["producto"]["id_producto"]; ?>" class="btn btn-danger btn-sm">Eliminar</a>
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

    <?php include __DIR__ . "/partials/pie.php"; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
