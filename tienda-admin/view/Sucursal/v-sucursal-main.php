<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Sucursales</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestion de Sucursales</h2>
        <div class="text-right mb-3">
            <a href="c-sucursal-new.php" class="btn btn-success">Agregar Sucursal</a>
            <a href="../c-panel.php" class="btn btn-secondary">Volver</a>
        </div>
        <table class="table table-bordered table-responsive-md">
            <thead class="thead-dark">
                <tr>
                    <th>Cod</th>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($sucursales)) { ?>
                    <?php foreach ($sucursales as $sucursal) { ?>
                        <tr>
                            <td><?php echo $sucursal->cod; ?></td>
                            <td><?php echo $sucursal->nombre; ?></td>
                            <td><?php echo $sucursal->direccion; ?></td>
                            <td><?php echo $sucursal->nroTelefono; ?></td>
                            <td><?php echo $sucursal->estado; ?></td>
                            <td>
                                <a href="c-sucursal-edit.php?cod=<?php echo $sucursal->cod; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="c-sucursal-delete.php?cod=<?php echo $sucursal->cod; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Estas seguro de que quieres eliminar esta sucursal?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr><td colspan="6" class="text-center">No hay sucursales registradas.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
