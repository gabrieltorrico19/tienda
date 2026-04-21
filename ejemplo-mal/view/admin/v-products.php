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
            <a href="c-admin-product-new.php" class="btn btn-success">Agregar Producto</a>
            <a href="c-admin-logout.php" class="btn btn-danger">Cerrar Sesion</a>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($productos)) { ?>
                    <?php foreach ($productos as $producto) { ?>
                        <tr>
                            <td><?php echo $producto["id_producto"]; ?></td>
                            <td><?php echo $producto["nombre"]; ?></td>
                            <td><?php echo $producto["descripcion"]; ?></td>
                            <td>$<?php echo number_format($producto["precio"], 2); ?></td>
                            <td><?php echo $producto["stock"]; ?></td>
                            <td>
                                <a href="c-admin-product-edit.php?id=<?php echo $producto["id_producto"]; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="c-admin-products.php?accion=eliminar&id=<?php echo $producto["id_producto"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Estas seguro de que quieres eliminar este producto?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr><td colspan="6" class="text-center">No hay productos disponibles.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
