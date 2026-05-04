<?php
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/tienda/tienda-admin';

require_once __DIR__ . "/../../model/RN_Sucursal.php";
require_once __DIR__ . "/../../model/RN_DetalleProductoSucursal.php";

$oRN_Sucursal = new RN_Sucursal();
$oRN_Detalle = new RN_DetalleProductoSucursal();

$sucursales = $oRN_Sucursal->GetList();
$codSucursal = isset($_GET["codSucursal"]) ? (int)$_GET["codSucursal"] : 0;

if ($codSucursal === 0 && !empty($sucursales)) {
    $codSucursal = (int)$sucursales[0]->cod;
}

$inventario = [];
if ($codSucursal !== 0) {
    $inventario = $oRN_Detalle->GetInventarioBySucursal($codSucursal);
}

$totalItems = count($inventario);
$totalStock = 0;
$lowStock = 0;
foreach ($inventario as $item) {
    $totalStock += $item["stock"];
    if ($item["stock"] < $item["stockMinimo"]) $lowStock++;
}

$sucursalNombre = '';
foreach ($sucursales as $s) {
    if ($s->cod == $codSucursal) {
        $sucursalNombre = $s->nombre;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario - Admin</title>
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
                <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-list.php" class="nav-item active">
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
                    <div class="page-title-icon">📋</div>
                    Inventario
                </div>
                <div class="page-actions">
                    <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-new.php?codSucursal=<?php echo $codSucursal; ?>" class="btn btn-primary">+ Agregar Stock</a>
                </div>
            </div>
            
            <div class="kpi-grid">
                <div class="kpi-card mint">
                    <div class="kpi-label">Total Items</div>
                    <div class="kpi-value"><?php echo $totalItems; ?></div>
                </div>
                <div class="kpi-card coral">
                    <div class="kpi-label">Stock Total</div>
                    <div class="kpi-value"><?php echo $totalStock; ?></div>
                </div>
                <div class="kpi-card pink">
                    <div class="kpi-label">Stock Bajo</div>
                    <div class="kpi-value"><?php echo $lowStock; ?></div>
                </div>
            </div>
            
            <div class="mb-4" style="display: flex; align-items: center; gap: 12px;">
                <label class="form-label" style="margin: 0; white-space: nowrap;">Sucursal:</label>
                <select class="form-control" style="max-width: 300px; padding-top: 16px; padding-bottom: 16px; font-size: 1rem;" onchange="window.location.href='?codSucursal='+this.value">
                    <option value="0">Seleccionar...</option>
                    <?php foreach ($sucursales as $sucursal) { ?>
                    <option value="<?php echo $sucursal->cod; ?>" <?php echo ($codSucursal == $sucursal->cod) ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($sucursal->nombre); ?>
                    </option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="data-card">
                <div class="data-card-header">
                    <div class="data-card-title">Inventario - <?php echo htmlspecialchars($sucursalNombre); ?></div>
                </div>
                <?php if (!empty($inventario)) { ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Marca</th>
                            <th>Stock</th>
                            <th>Stock Mín.</th>
                            <th>Nivel</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventario as $item) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item["nombre"]); ?></td>
                            <td><?php echo htmlspecialchars($item["marca"]); ?></td>
                            <td><?php echo $item["stock"]; ?></td>
                            <td><?php echo $item["stockMinimo"]; ?></td>
                            <td>
                                <span class="badge <?php echo $item["stock"] < $item["stockMinimo"] ? 'badge-danger' : 'badge-success'; ?>">
                                    <?php echo $item["nivelStock"]; ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-edit.php?codProducto=<?php echo $item["cod"]; ?>&codSucursal=<?php echo $codSucursal; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-delete.php?codProducto=<?php echo $item["cod"]; ?>&codSucursal=<?php echo $codSucursal; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este stock?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <div class="empty-state-text">No hay inventario para esta sucursal</div>
                    <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-new.php?codSucursal=<?php echo $codSucursal; ?>" class="btn btn-primary mt-4">+ Agregar Stock</a>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>