<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inicio de Sesion - Cliente</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
	<div class="container mt-5">
		<h2 class="text-center">Inicio de Sesion - Cliente</h2>
		<?php if (isset($error)) { echo '<div class="alert alert-danger">' . $error . '</div>'; } ?>
		<form method="POST" action="c-auth.php">
			<input type="hidden" name="next" value="<?php echo htmlspecialchars($next ?? "", ENT_QUOTES, 'UTF-8'); ?>">
			<div class="form-group">
				<label for="usuario">Usuario:</label>
				<input type="text" class="form-control" id="usuario" name="user" required>
			</div>
			<div class="form-group">
				<label for="password">Contrasena:</label>
				<input type="password" class="form-control" id="password" name="pass" required>
			</div>
			<button type="submit" class="btn btn-primary btn-block">Iniciar Sesion</button>
		</form>
		<div class="text-center mt-3">
			<a href="../index.php" class="btn btn-outline-secondary">Entrar como invitado</a>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
