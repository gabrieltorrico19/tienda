<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inicio de Sesión - Cliente</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/tienda/tienda-cliente/view/css/main.css">
</head>
<body>
	<div class="auth-container">
		<div class="auth-card">
			<div class="auth-logo">
				<div class="auth-logo-icon">🛒</div>
				<h1 class="auth-title">¡Bienvenido de nuevo!</h1>
				<p class="auth-subtitle">Inicia sesión para continuar</p>
			</div>

			<?php if (isset($error)) { echo '<div class="alert-error">' . htmlspecialchars($error) . '</div>'; } ?>
			<?php if (isset($_GET["registered"])) { echo '<div class="alert-success">¡Cuenta creada exitosamente! Ahora inicia sesión.</div>'; } ?>

			<form method="POST" action="../../../tienda-cliente/control/c-auth.php" class="auth-form">
				<input type="hidden" name="next" value="<?php echo htmlspecialchars($next ?? "", ENT_QUOTES, 'UTF-8'); ?>">
				
				<div class="form-group">
					<label class="form-label" for="usuario">Usuario</label>
					<input type="text" class="form-control" id="usuario" name="user" required placeholder="Tu usuario">
				</div>

				<div class="form-group">
					<label class="form-label" for="password">Contraseña</label>
					<input type="password" class="form-control" id="password" name="pass" required placeholder="Tu contraseña">
				</div>

				<button type="submit" class="btn-auth">Iniciar Sesión</button>
			</form>

			<div class="auth-footer">
				<p>¿No tienes cuenta? <a href="v-register.php" class="auth-link">Regístrate aquí</a></p>
				<p class="mt-3"><a href="../../index.php" class="auth-link-secondary">Entrar como invitado →</a></p>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>