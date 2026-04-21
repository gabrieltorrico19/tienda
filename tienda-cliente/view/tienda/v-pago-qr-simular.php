<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simular Pago QR</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #090b10;
            --surface-dark: #12161f;
            --surface-hover: #1b212e;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent-glow: #00f0ff;
            --accent-purple: #8a2be2;
            --border-color: #272d3b;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background: #090b10 radial-gradient(circle at top left, #161c28, #090b10);
            color: var(--text-primary);
            min-height: 100vh;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #ffffff;
            font-weight: 800;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }
        p, label, span {
            color: var(--text-secondary);
        }
        .container {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }
        .card {
            background-color: rgba(18, 22, 31, 0.7);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.5);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            color: var(--text-primary);
        }
        .card-body h5 {
            color: var(--accent-glow);
        }
        .card:hover {
            transform: translateY(-10px);
            border-color: rgba(0, 240, 255, 0.3);
            box-shadow: 0 20px 50px rgba(0, 240, 255, 0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent-glow), #0077ff);
            border: none;
            color: #000 !important;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 240, 255, 0.4);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0077ff, var(--accent-glow));
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 240, 255, 0.6);
        }
        .btn-danger {
            background: rgba(255, 59, 48, 0.1);
            border: 1px solid rgba(255, 59, 48, 0.5);
            color: #ff3b30;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-danger:hover {
            background: #ff3b30;
            color: #fff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 59, 48, 0.4);
        }
        .form-control {
            background-color: var(--surface-dark);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: var(--text-primary);
            padding: 12px 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            background-color: #0d1117;
            border-color: var(--accent-glow);
            color: #fff;
            box-shadow: 0 0 0 4px rgba(0, 240, 255, 0.15);
            outline: none;
        }
        select.form-control option {
            background-color: #0d1117;
            color: #ffffff;
        }
        table.table {
            background-color: rgba(18, 22, 31, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.05);
            color: var(--text-primary);
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
        }
        table.table thead th {
            background-color: rgba(0,0,0,0.6);
            color: var(--accent-glow);
            font-weight: 800;
            border-bottom: 2px solid rgba(255,255,255,0.05);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-size: 0.85rem;
            padding: 16px;
        }
        table.table tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s;
        }
        table.table tbody tr:hover {
            background-color: rgba(0, 240, 255, 0.05);
            transform: scale(1.005);
        }
        table.table td {
            border-top: none;
            vertical-align: middle;
            color: var(--text-primary);
            padding: 16px;
        }
        .list-group-item {
            background-color: transparent !important;
            border-color: rgba(255,255,255,0.05);
            color: var(--text-primary);
        }
        /* Fixes for Navbar and Light Classes */
        .bg-light, .navbar-light {
            background-color: rgba(18, 22, 31, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
        }
        .navbar-light .navbar-brand, 
        .navbar-light .navbar-nav .nav-link {
            color: var(--text-primary) !important;
            font-weight: 600;
            text-transform: uppercase;
        }
        .navbar-light .navbar-nav .nav-link:hover {
            color: var(--accent-glow) !important;
        }
        .navbar-light .navbar-toggler {
            border-color: rgba(255,255,255,0.2) !important;
            background-color: rgba(255,255,255,0.1);
        }
        .navbar-light .navbar-toggler-icon {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        /* Footer fixes */
        .bg-dark {
            background-color: #07090d !important;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
        ::placeholder { color: var(--text-secondary); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="c-home.php">
            <img src="https://getbootstrap.com/docs/4.5/assets/brand/bootstrap-solid.svg" width="30" height="30" alt="Logo" class="d-inline-block align-top">
            <?php echo $appTitle; ?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="c-home.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="c-cart.php">Carrito</a></li>
                <li class="nav-item"><a class="nav-link" href="c-checkout.php">Pagar</a></li>
                <?php if (!empty($clienteUsuario)) { ?>
                    <li class="nav-item"><a class="nav-link" href="../c-logout.php">Salir (<?php echo $clienteUsuario; ?>)</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a class="nav-link" href="../c-login.php">Iniciar Sesion</a></li>
                <?php } ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Simulacion de Pago</h2>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Resumen de la venta</h5>
                <ul class="list-group list-group-flush">
                    <?php foreach ($items as $item) { ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo $item["nombre"]; ?> x <?php echo $item["cantidad"]; ?>
                            <span>$<?php echo number_format($item["subtotal"], 2); ?></span>
                        </li>
                    <?php } ?>
                </ul>
                <div class="text-right mt-3">
                    <strong>Total: $<?php echo number_format($nota->totalVenta, 2); ?></strong>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="c-comprobante-pdf.php?nro=<?php echo $nota->nro; ?>" class="btn btn-success">Generar Comprobante PDF</a>
            <a href="c-home.php" class="btn btn-secondary">Finalizar</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




