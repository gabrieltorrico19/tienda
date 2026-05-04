<?php
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/tienda/tienda-admin';

require_once __DIR__ . "/../../model/RN_Producto.php";
require_once __DIR__ . "/../../model/RN_Categoria.php";
require_once __DIR__ . "/../../model/RN_Marca.php";
require_once __DIR__ . "/../../model/RN_Industria.php";
require_once __DIR__ . "/../../model/RN_FormaPago.php";
require_once __DIR__ . "/../../model/RN_Sucursal.php";
require_once __DIR__ . "/../../model/RN_NotaVenta.php";
require_once __DIR__ . "/../../model/RN_Cliente.php";

$productoRN = new RN_Producto();
$categoriaRN = new RN_Categoria();
$marcaRN = new RN_Marca();
$industriaRN = new RN_Industria();
$formaPagoRN = new RN_FormaPago();
$sucursalRN = new RN_Sucursal();
$notaVentaRN = new RN_NotaVenta();
$clienteRN = new RN_Cliente();

$productos = $productoRN->GetList();
$categorias = $categoriaRN->GetList();
$marcas = $marcaRN->GetList();
$industrias = $industriaRN->GetList();
$formaPagos = $formaPagoRN->GetList();
$sucursales = $sucursalRN->GetList();
$notasVenta = $notaVentaRN->GetList();
$clientes = $clienteRN->GetList();

$totalProductos = count($productos);
$totalCategorias = count($categorias);
$totalMarcas = count($marcas);
$totalIndustrias = count($industrias);
$totalFormaPagos = count($formaPagos);
$totalSucursales = count($sucursales);
$totalVentas = count($notasVenta);
$totalClientes = count($clientes);

$ventasCompletadas = 0;
$ventasPendientes = 0;
foreach ($notasVenta as $v) {
    if ($v->estado === 'completada') $ventasCompletadas++;
    elseif ($v->estado === 'pendiente') $ventasPendientes++;
}

$productosActivos = 0;
foreach ($productos as $p) {
    if ($p->estado === 'disponible') $productosActivos++;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/view/css/main.css">
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="<?php echo $baseUrl; ?>/control/admin/c-admin-panel.php" class="sidebar-brand">
                    <span>🌿</span> Tienda Admin
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">Principal</div>
                <a href="<?php echo $baseUrl; ?>/control/admin/c-admin-panel.php" class="nav-item active">
                    <span class="nav-icon">📊</span> Dashboard
                </a>
                
                <div class="nav-section">Gestión</div>
                <a href="<?php echo $baseUrl; ?>/control/Producto/c-producto-list.php" class="nav-item">
                    <span class="nav-icon">📦</span> Productos
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Categoria/c-categoria-list.php" class="nav-item">
                    <span class="nav-icon">🏷️</span> Categorías
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Marca/c-marca-list.php" class="nav-item">
                    <span class="nav-icon">🏅</span> Marcas
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Industria/c-industria-list.php" class="nav-item">
                    <span class="nav-icon">🏭</span> Industrias
                </a>
                <a href="<?php echo $baseUrl; ?>/control/FormaPago/c-formapago-list.php" class="nav-item">
                    <span class="nav-icon">💳</span> Formas de Pago
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Sucursal/c-sucursal-list.php" class="nav-item">
                    <span class="nav-icon">🏪</span> Sucursales
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-list.php" class="nav-item">
                    <span class="nav-icon">📋</span> Inventario
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Usuario/c-usuario-admin-list.php" class="nav-item">
                    <span class="nav-icon">🛡️</span> Administradores
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Usuario/c-usuario-cliente-list.php" class="nav-item">
                    <span class="nav-icon">👥</span> Clientes
                </a>
                
                <div class="nav-section">Comunicación</div>
                <a href="<?php echo $baseUrl; ?>/control/chat/c-chat-panel.php" class="nav-item">
                    <span class="nav-icon">💬</span> Chat
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <a href="<?php echo $baseUrl; ?>/control/auth/c-login.php" class="logout-btn">
                    <span class="nav-icon">🚪</span> Cerrar Sesión
                </a>
            </div>
        </aside>
        
        <main class="main-content">
            <div class="page-header">
                <div class="page-title">
                    <div class="page-title-icon">📊</div>
                    Dashboard
                </div>
            </div>
            
            <!-- KPIs -->
            <div class="kpi-grid">
                <div class="kpi-card mint">
                    <div class="kpi-label">Total Productos</div>
                    <div class="kpi-value"><?php echo $totalProductos; ?></div>
                    <div class="kpi-subtitle"><?php echo $productosActivos; ?> disponibles</div>
                </div>
                <div class="kpi-card coral">
                    <div class="kpi-label">Ventas Totales</div>
                    <div class="kpi-value"><?php echo $totalVentas; ?></div>
                    <div class="kpi-subtitle"><?php echo $ventasPendientes; ?> pendientes</div>
                </div>
                <div class="kpi-card lavender">
                    <div class="kpi-label">Clientes</div>
                    <div class="kpi-value"><?php echo $totalClientes; ?></div>
                    <div class="kpi-subtitle">registrados</div>
                </div>
                <div class="kpi-card blue">
                    <div class="kpi-label">Sucursales</div>
                    <div class="kpi-value"><?php echo $totalSucursales; ?></div>
                    <div class="kpi-subtitle">activas</div>
                </div>
                <div class="kpi-card pink">
                    <div class="kpi-label">Categorías</div>
                    <div class="kpi-value"><?php echo $totalCategorias; ?></div>
                    <div class="kpi-subtitle">registradas</div>
                </div>
                <div class="kpi-card purple">
                    <div class="kpi-label">Marcas</div>
                    <div class="kpi-value"><?php echo $totalMarcas; ?></div>
                    <div class="kpi-subtitle">registradas</div>
                </div>
            </div>
            
            <!-- Módulos -->
            <div class="data-card">
                <div class="data-card-header">
                    <div class="data-card-title">Módulos de Gesti��n</div>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Módulo</th>
                            <th>Registros</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>📦 Productos</td>
                            <td><?php echo $totalProductos; ?></td>
                            <td><span class="badge badge-success"><?php echo $productosActivos; ?> activos</span></td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Producto/c-producto-list.php" class="btn btn-sm btn-secondary">Ver</a>
                                <a href="<?php echo $baseUrl; ?>/control/Producto/c-producto-new.php" class="btn btn-sm btn-primary">+ Nuevo</a>
                            </td>
                        </tr>
                        <tr>
                            <td>🏷️ Categorías</td>
                            <td><?php echo $totalCategorias; ?></td>
                            <td><span class="badge badge-success">activo</span></td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Categoria/c-categoria-list.php" class="btn btn-sm btn-secondary">Ver</a>
                                <a href="<?php echo $baseUrl; ?>/control/Categoria/c-categoria-new.php" class="btn btn-sm btn-primary">+ Nueva</a>
                            </td>
                        </tr>
                        <tr>
                            <td>🏅 Marcas</td>
                            <td><?php echo $totalMarcas; ?></td>
                            <td><span class="badge badge-success">activo</span></td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Marca/c-marca-list.php" class="btn btn-sm btn-secondary">Ver</a>
                                <a href="<?php echo $baseUrl; ?>/control/Marca/c-marca-new.php" class="btn btn-sm btn-primary">+ Nueva</a>
                            </td>
                        </tr>
                        <tr>
                            <td>🏭 Industrias</td>
                            <td><?php echo $totalIndustrias; ?></td>
                            <td><span class="badge badge-success">activo</span></td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Industria/c-industria-list.php" class="btn btn-sm btn-secondary">Ver</a>
                                <a href="<?php echo $baseUrl; ?>/control/Industria/c-industria-new.php" class="btn btn-sm btn-primary">+ Nueva</a>
                            </td>
                        </tr>
                        <tr>
                            <td>💳 Formas de Pago</td>
                            <td><?php echo $totalFormaPagos; ?></td>
                            <td><span class="badge badge-success">activo</span></td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/FormaPago/c-formapago-list.php" class="btn btn-sm btn-secondary">Ver</a>
                                <a href="<?php echo $baseUrl; ?>/control/FormaPago/c-formapago-new.php" class="btn btn-sm btn-primary">+ Nueva</a>
                            </td>
                        </tr>
                        <tr>
                            <td>🏪 Sucursales</td>
                            <td><?php echo $totalSucursales; ?></td>
                            <td><span class="badge badge-success">activo</span></td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Sucursal/c-sucursal-list.php" class="btn btn-sm btn-secondary">Ver</a>
                                <a href="<?php echo $baseUrl; ?>/control/Sucursal/c-sucursal-new.php" class="btn btn-sm btn-primary">+ Nueva</a>
                            </td>
                        </tr>
                        <tr>
                            <td>📋 Inventario</td>
                            <td>-</td>
                            <td><span class="badge badge-info">stock</span></td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-list.php" class="btn btn-sm btn-secondary">Ver</a>
                                <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-new.php" class="btn btn-sm btn-primary">+ Nuevo</a>
                            </td>
                        </tr>
                        <tr>
                            <td>💬 Chat</td>
                            <td>-</td>
                            <td><span class="badge badge-success">en línea</span></td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/chat/c-chat-panel.php" class="btn btn-sm btn-primary">Abrir</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
