<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago</title>
    <link rel="stylesheet" href="../recursos/css/estilos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include __DIR__ . "/partials/encabezado.php"; ?>

    <div class="container mt-5">
        <h1 class="text-center">Proceso de Pago</h1>
        <form method="POST" action="">
            <div class="alert alert-info text-center">
                <p>Este es un proceso de pago simulado. Haz clic en "Completar Compra" para finalizar tu compra.</p>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-success">Completar Compra</button>
            </div>
        </form>
    </div>

    <?php include __DIR__ . "/partials/pie.php"; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
