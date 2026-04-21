<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Tienda en Linea</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include __DIR__ . "/partials/encabezado.php"; ?>

    <div class="container mt-5">
        <h1 class="text-center">Bienvenido a nuestra tienda en linea</h1>
        <div class="row">
            <?php if (!empty($productos)) { ?>
                <?php foreach ($productos as $producto) { ?>
                    <?php $rutaImagen = "../recursos/" . $producto["imagen"]; ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <a href="<?php echo $rutaImagen; ?>" target="_blank">
                                <div class="card-img-top" style="height: 200px; overflow: hidden;">
                                    <img src="<?php echo $rutaImagen; ?>" class="img-fluid" alt="<?php echo $producto["nombre"]; ?>" style="width: 100%; object-fit: cover; height: 100%;">
                                </div>
                            </a>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $producto["nombre"]; ?></h5>
                                <p class="card-text"><?php echo $producto["descripcion"]; ?></p>
                                <p class="card-text"><strong>Precio: $<?php echo number_format($producto["precio"], 2); ?></strong></p>
                                <a href="c-cart.php?accion=agregar&id=<?php echo $producto["id_producto"]; ?>" class="btn btn-primary">Agregar al carrito</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-center">No hay productos disponibles en este momento.</p>
            <?php } ?>
        </div>
    </div>

    <?php include __DIR__ . "/partials/pie.php"; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
