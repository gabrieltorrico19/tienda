<?php
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/tienda/tienda-admin';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/view/css/main.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-logo">
                <div class="login-logo-icon">🌿</div>
                <h1 class="login-title">Tienda Admin</h1>
                <p class="login-subtitle">Ingresa a tu cuenta</p>
            </div>
            
            <?php if (isset($error)) { ?>
            <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php } ?>
            
            <form method="POST" action="<?php echo $baseUrl; ?>/control/auth/c-auth.php">
                <div class="form-group">
                    <label class="form-label" for="usuario">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="user" placeholder="Usuario" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="pass" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn-login">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>