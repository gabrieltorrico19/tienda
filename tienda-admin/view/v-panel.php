<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Panel de Control - Administracion</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
						<h5 class="card-title">Gestionar Productos</h5>
						<p class="card-text">Agregar, editar y eliminar productos.</p>
						<a href="Producto/c-producto-list.php" class="btn btn-primary">Ir a Productos</a>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<div class="card-body text-center">
						<h5 class="card-title">Gestionar Formas de Pago</h5>
						<p class="card-text">Agregar, editar y eliminar formas de pago.</p>
						<a href="FormaPago/c-formapago-list.php" class="btn btn-primary">Ir a Formas de Pago</a>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<div class="card-body text-center">
						<h5 class="card-title">Gestionar Categorias</h5>
						<p class="card-text">Agregar, editar y eliminar categorias.</p>
						<a href="Categoria/c-categoria-list.php" class="btn btn-primary">Ir a Categorias</a>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<div class="card-body text-center">
						<h5 class="card-title">Gestionar Industrias</h5>
						<p class="card-text">Agregar, editar y eliminar industrias.</p>
						<a href="Industria/c-industria-list.php" class="btn btn-primary">Ir a Industrias</a>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<div class="card-body text-center">
						<h5 class="card-title">Gestionar Marcas</h5>
						<p class="card-text">Agregar, editar y eliminar marcas.</p>
						<a href="Marca/c-marca-list.php" class="btn btn-primary">Ir a Marcas</a>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<div class="card-body text-center">
						<h5 class="card-title">Gestionar Sucursales</h5>
						<p class="card-text">Agregar, editar y eliminar sucursales.</p>
						<a href="Sucursal/c-sucursal-list.php" class="btn btn-primary">Ir a Sucursales</a>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-4">
				<div class="card">
					<div class="card-body text-center">
						<h5 class="card-title">Gestionar Inventario</h5>
						<p class="card-text">Actualizar stock por sucursal.</p>
						<a href="Inventario/c-inventario-list.php" class="btn btn-primary">Ir a Inventario</a>
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
