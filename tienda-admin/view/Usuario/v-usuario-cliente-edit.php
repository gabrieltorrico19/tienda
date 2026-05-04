<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/view/css/main.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Editar Cliente</h2>
        <?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>
        <form action="c-usuario-cliente-update.php" method="POST">
            <div class="form-group">
                <label for="ci">CI:</label>
                <input type="text" class="form-control" id="ci" name="ci" value="<?php echo htmlspecialchars($oCliente->ci); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="nombres">Nombres:</label>
                <input type="text" class="form-control" id="nombres" name="nombres" value="<?php echo htmlspecialchars($oCliente->nombres); ?>" required>
            </div>
            <div class="form-group">
                <label for="apPaterno">Apellido Paterno:</label>
                <input type="text" class="form-control" id="apPaterno" name="apPaterno" value="<?php echo htmlspecialchars($oCliente->apPaterno); ?>" required>
            </div>
            <div class="form-group">
                <label for="apMaterno">Apellido Materno:</label>
                <input type="text" class="form-control" id="apMaterno" name="apMaterno" value="<?php echo htmlspecialchars($oCliente->apMaterno); ?>" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($oCliente->correo); ?>" required>
            </div>
            <div class="form-group">
                <label for="direccion">Direccion:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo htmlspecialchars($oCliente->direccion); ?>" required>
            </div>
            <div class="form-group">
                <label for="nroCelular">Celular:</label>
                <input type="text" class="form-control" id="nroCelular" name="nroCelular" value="<?php echo htmlspecialchars($oCliente->nroCelular); ?>" required>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo htmlspecialchars($oCliente->usuarioCuenta); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="text" class="form-control" id="password" name="password" value="<?php echo htmlspecialchars($oCuenta ? $oCuenta->password : ""); ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <select class="form-control form-control-lg" id="estado" name="estado" required>
                    <option value="activo" <?php echo $oCliente->estado === "activo" ? "selected" : ""; ?>>Activo</option>
                    <option value="inactivo" <?php echo $oCliente->estado === "inactivo" ? "selected" : ""; ?>>Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
            <a href="c-usuario-cliente-list.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
