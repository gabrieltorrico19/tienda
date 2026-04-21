<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestion de Productos</h2>
        <div class="text-right mb-3">
            <a href="c-producto-new.php" class="btn btn-success">Agregar Producto</a>
            <a href="../c-panel.php" class="btn btn-secondary">Volver</a>
        </div>
        <table class="table table-bordered table-responsive-md">
            <thead class="thead-dark">
                <tr>
                    <th>Cod</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Estado</th>
                    <th>Marca</th>
                    <th>Industria</th>
                    <th>Categoria</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos)) { ?>
                    <?php foreach ($productos as $producto) { ?>
                        <tr>
                            <td><?php echo $producto->cod; ?></td>
                            <td><?php echo $producto->nombre; ?></td>
                            <td><?php echo $producto->descripcion; ?></td>
                            <td><?php echo number_format($producto->precio, 2); ?></td>
                            <td><?php echo $producto->estado; ?></td>
                            <td><?php echo $producto->marca; ?></td>
                            <td><?php echo $producto->industria; ?></td>
                            <td><?php echo $producto->categoria; ?></td>
                            <td>
                                <span><?php echo $producto->imagen; ?></span>
                            </td>
                            <td>
                                <a href="c-producto-edit.php?cod=<?php echo $producto->cod; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="c-producto-delete.php?cod=<?php echo $producto->cod; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Estas seguro de que quieres eliminar este producto?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr><td colspan="10" class="text-center">No hay productos disponibles.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
