<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Stock</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Editar Stock</h2>
        <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>
        <form action="c-inventario-update.php" method="POST">
            <input type="hidden" name="codProducto" value="<?php echo $oDetalle->codProducto; ?>">
            <input type="hidden" name="codSucursal" value="<?php echo $oDetalle->codSucursal; ?>">
            <div class="form-group">
                <label>Producto:</label>
                <input type="text" class="form-control" value="<?php echo $oProducto ? $oProducto->nombre : $oDetalle->codProducto; ?>" readonly>
            </div>
            <div class="form-group">
                <label>Sucursal:</label>
                <input type="text" class="form-control" value="<?php echo $oSucursal ? $oSucursal->nombre : $oDetalle->codSucursal; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?php echo $oDetalle->stock; ?>" required>
            </div>
            <div class="form-group">
                <label for="stockMinimo">Stock Minimo:</label>
                <input type="number" class="form-control" id="stockMinimo" name="stockMinimo" min="0" value="<?php echo $oDetalle->stockMinimo; ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="c-inventario-list.php?codSucursal=<?php echo $oDetalle->codSucursal; ?>" class="btn btn-secondary">Volver</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
