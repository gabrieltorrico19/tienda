<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registro - Cliente</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/tienda/tienda-cliente/view/css/main.css">
</head>
<body>
	<div class="auth-container">
		<div class="auth-card">
			<div class="auth-logo">
				<div class="auth-logo-icon">✨</div>
				<h1 class="auth-title">Crear Cuenta</h1>
				<p class="auth-subtitle">Regístrate para hacer pedidos en nuestra tienda</p>
			</div>

			<?php if (isset($error)) { echo '<div class="alert-error">' . htmlspecialchars($error) . '</div>'; } ?>
			<?php if (isset($success)) { echo '<div class="alert-success">' . htmlspecialchars($success) . '</div>'; } ?>

			<form method="POST" action="../../control/auth/c-register.php" class="auth-form">
				<input type="hidden" name="next" value="<?php echo htmlspecialchars($next ?? "", ENT_QUOTES, 'UTF-8'); ?>">
				
				<div class="form-group">
					<label class="form-label" for="ci">Cédula de Identidad *</label>
					<input type="text" class="form-control" id="ci" name="ci" required placeholder="Ej: 12345678">
				</div>

				<div class="form-row-2">
					<div class="form-group">
						<label class="form-label" for="nombres">Nombres *</label>
						<input type="text" class="form-control" id="nombres" name="nombres" required placeholder="Tus nombres">
					</div>
					<div class="form-group">
						<label class="form-label" for="apPaterno">Apellido Paterno *</label>
						<input type="text" class="form-control" id="apPaterno" name="apPaterno" required placeholder="Tu apellido">
					</div>
				</div>

				<div class="form-group">
					<label class="form-label" for="apMaterno">Apellido Materno</label>
					<input type="text" class="form-control" id="apMaterno" name="apMaterno" placeholder="Tu segundo apellido">
				</div>

				<div class="form-group">
					<label class="form-label" for="correo">Correo Electrónico *</label>
					<input type="email" class="form-control" id="correo" name="correo" required placeholder="correo@ejemplo.com">
				</div>

				<div class="form-group">
					<label class="form-label" for="nroCelular">Teléfono / Celular *</label>
					<input type="text" class="form-control" id="nroCelular" name="nroCelular" required placeholder="77712345">
				</div>

				<div class="form-group">
					<label class="form-label" for="direccion">Dirección</label>
					<input type="text" class="form-control" id="direccion" name="direccion" placeholder="Tu dirección">
				</div>

				<div class="form-divider"></div>

				<div class="form-group">
					<label class="form-label" for="usuario">Usuario *</label>
					<input type="text" class="form-control" id="usuario" name="usuario" required placeholder="Elige tu usuario">
				</div>

				<div class="form-group">
					<label class="form-label" for="password">Contraseña *</label>
					<input type="password" class="form-control" id="password" name="password" required placeholder="Mínimo 6 caracteres" minlength="6">
				</div>

				<div class="form-group">
					<label class="form-label" for="password2">Confirmar Contraseña *</label>
					<input type="password" class="form-control" id="password2" name="password2" required placeholder="Repite tu contraseña" minlength="6">
				</div>

				<button type="submit" class="btn-auth">Crear Mi Cuenta ✨</button>
			</form>

			<div class="auth-footer">
				<p>¿Ya tienes cuenta? <a href="v-login.php?next=<?php echo urlencode($next ?? ""); ?>" class="auth-link">Inicia sesión aquí</a></p>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>