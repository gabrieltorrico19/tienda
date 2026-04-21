<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Stock</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Agregar Stock</h2>
        <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>
        <form action="c-inventario-save.php" method="POST">
            <div class="form-group">
                <label for="codSucursal">Sucursal:</label>
                <select class="form-control" id="codSucursal" name="codSucursal" required>
                    <option value="0">Seleccione...</option>
                    <?php foreach ($sucursales as $sucursal) { ?>
                        <option value="<?php echo $sucursal->cod; ?>" <?php echo ($codSucursal == $sucursal->cod) ? "selected" : ""; ?>>
                            <?php echo $sucursal->nombre; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="codProducto">Producto:</label>
                <select class="form-control" id="codProducto" name="codProducto" required>
                    <option value="0">Seleccione...</option>
                    <?php foreach ($productos as $producto) { ?>
                        <option value="<?php echo $producto->cod; ?>">
                            <?php echo $producto->nombre; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" class="form-control" id="stock" name="stock" min="0" required>
            </div>
            <div class="form-group">
                <label for="stockMinimo">Stock Minimo:</label>
                <input type="number" class="form-control" id="stockMinimo" name="stockMinimo" min="0" value="5" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="c-inventario-list.php?codSucursal=<?php echo $codSucursal; ?>" class="btn btn-secondary">Volver</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
