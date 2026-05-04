<?php
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/tienda/tienda-admin';

require_once __DIR__ . "/../../model/RN_Producto.php";

$oRN_Producto = new RN_Producto();
$productos = $oRN_Producto->GetList();

$totalProductos = count($productos);
$productosActivos = 0;
$productosInactivos = 0;

foreach ($productos as $p) {
    if ($p->estado === 'disponible') $productosActivos++;
    else $productosInactivos++;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Admin</title>
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
                <a href="<?php echo $baseUrl; ?>/control/admin/c-admin-panel.php" class="nav-item">
                    <span class="nav-icon">📊</span> Dashboard
                </a>
                <div class="nav-section">Gestión</div>
                <a href="<?php echo $baseUrl; ?>/control/Producto/c-producto-list.php" class="nav-item active">
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
                    <div class="page-title-icon">📦</div>
                    Productos
                </div>
                <div class="page-actions">
                    <a href="<?php echo $baseUrl; ?>/control/Producto/c-producto-new.php" class="btn btn-primary">+ Nuevo Producto</a>
                </div>
            </div>
            
            <div class="kpi-grid">
                <div class="kpi-card mint">
                    <div class="kpi-label">Total</div>
                    <div class="kpi-value"><?php echo $totalProductos; ?></div>
                </div>
                <div class="kpi-card coral">
                    <div class="kpi-label">Disponibles</div>
                    <div class="kpi-value"><?php echo $productosActivos; ?></div>
                </div>
                <div class="kpi-card pink">
                    <div class="kpi-label">Inactivos</div>
                    <div class="kpi-value"><?php echo $productosInactivos; ?></div>
                </div>
            </div>
            
            <div class="data-card">
                <div class="data-card-header">
                    <div class="data-card-title">Lista de Productos</div>
                </div>
                <?php if (!empty($productos)) { ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Marca</th>
                            <th>Industria</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto) { ?>
                        <tr>
                            <td><?php echo $producto->cod; ?></td>
                            <td><?php echo htmlspecialchars($producto->nombre); ?></td>
                            <td><?php echo htmlspecialchars($producto->descripcion); ?></td>
                            <td>Bs. <?php echo number_format($producto->precio, 2); ?></td>
                            <td>
                                <span class="badge <?php echo $producto->estado === 'disponible' ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo $producto->estado; ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($producto->marca); ?></td>
                            <td><?php echo htmlspecialchars($producto->industria); ?></td>
                            <td><?php echo htmlspecialchars($producto->categoria); ?></td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Producto/c-producto-edit.php?cod=<?php echo $producto->cod; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="<?php echo $baseUrl; ?>/control/Producto/c-producto-delete.php?cod=<?php echo $producto->cod; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este producto?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <div class="empty-state-text">No hay productos registrados</div>
                    <a href="<?php echo $baseUrl; ?>/control/Producto/c-producto-new.php" class="btn btn-primary mt-4">+ Agregar Primer Producto</a>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>