<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panel de Control - Administracion</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/view/css/main.css">
</head>
<body>
	<div class="container mt-5">
		<h2 class="text-center">Panel de Control - Administracion</h2>
		<div class="text-right mb-3">
			<a href="c-login.php" class="btn btn-danger">Cerrar Sesion</a>
		</div>
		<div class="row">
			<div class="col-md-4 mb-4">
				<div class="card">
					<div class="card-body text-center">
						<h5 class="card-title">Gestionar Clientes</h5>
						<p class="card-text">Alta, edicion y bajas de clientes.</p>
						<a href="#" class="btn btn-primary">Ir a Clientes</a>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<div class="card-body text-center">
						<h5 class="card-title">Gestionar Ventas</h5>
						<p class="card-text">Registro y seguimiento de ventas.</p>
						<a href="#" class="btn btn-primary">Ir a Ventas</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




