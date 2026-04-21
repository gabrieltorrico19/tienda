<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Industrias</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gestion de Industrias</h2>
        <div class="text-right mb-3">
            <a href="c-industria-new.php" class="btn btn-success">Agregar Industria</a>
            <a href="../c-panel.php" class="btn btn-secondary">Volver</a>
        </div>
        <table class="table table-bordered table-responsive-md">
            <thead class="thead-dark">
                <tr>
                    <th>Cod</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($industrias)) { ?>
                    <?php foreach ($industrias as $industria) { ?>
                        <tr>
                            <td><?php echo $industria->cod; ?></td>
                            <td><?php echo $industria->nombre; ?></td>
                            <td>
                                <a href="c-industria-edit.php?cod=<?php echo $industria->cod; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="c-industria-delete.php?cod=<?php echo $industria->cod; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Estas seguro de que quieres eliminar esta industria?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr><td colspan="3" class="text-center">No hay industrias registradas.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
