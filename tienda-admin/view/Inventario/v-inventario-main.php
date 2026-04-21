<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Inventario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestion de Inventario por Sucursal</h2>

        <form method="GET" class="form-inline mb-3">
            <label for="codSucursal" class="mr-2">Sucursal:</label>
            <select class="form-control mr-2" id="codSucursal" name="codSucursal" onchange="this.form.submit()">
                <option value="0">Seleccione...</option>
                <?php foreach ($sucursales as $sucursal) { ?>
                    <option value="<?php echo $sucursal->cod; ?>" <?php echo ($codSucursal == $sucursal->cod) ? "selected" : ""; ?>>
                        <?php echo $sucursal->nombre; ?>
                    </option>
                <?php } ?>
            </select>
            <noscript>
                <button type="submit" class="btn btn-primary">Ver</button>
            </noscript>
        </form>

        <div class="text-right mb-3">
            <a href="c-inventario-new.php?codSucursal=<?php echo $codSucursal; ?>" class="btn btn-success">Agregar Stock</a>
            <a href="../c-panel.php" class="btn btn-secondary">Volver</a>
        </div>

        <table class="table table-bordered table-responsive-md">
            <thead class="thead-dark">
                <tr>
                    <th>Cod</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Categoria</th>
                    <th>Stock</th>
                    <th>Stock Minimo</th>
                    <th>Nivel</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($inventario)) { ?>
                    <?php foreach ($inventario as $item) { ?>
                        <tr>
                            <td><?php echo $item["cod"]; ?></td>
                            <td><?php echo $item["nombre"]; ?></td>
                            <td><?php echo $item["marca"]; ?></td>
                            <td><?php echo $item["categoria"]; ?></td>
                            <td><?php echo $item["stock"]; ?></td>
                            <td><?php echo $item["stockMinimo"]; ?></td>
                            <td><?php echo $item["nivelStock"]; ?></td>
                            <td>
                                <a href="c-inventario-edit.php?codProducto=<?php echo $item["cod"]; ?>&codSucursal=<?php echo $codSucursal; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="c-inventario-delete.php?codProducto=<?php echo $item["cod"]; ?>&codSucursal=<?php echo $codSucursal; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Estas seguro de que quieres eliminar este stock?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr><td colspan="8" class="text-center">No hay inventario para esta sucursal.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
