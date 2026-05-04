<?php
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/tienda/tienda-admin';

require_once __DIR__ . "/../../model/RN_Sucursal.php";

$oRN_Sucursal = new RN_Sucursal();
$sucursales = $oRN_Sucursal->GetList();

$totalSucursales = count($sucursales);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sucursales - Admin</title>
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
                <a href="<?php echo $baseUrl; ?>/control/Sucursal/c-sucursal-list.php" class="nav-item active">
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
                    <div class="page-title-icon">🏪</div>
                    Sucursales
                </div>
                <div class="page-actions">
                    <a href="<?php echo $baseUrl; ?>/control/Sucursal/c-sucursal-new.php" class="btn btn-primary">+ Nueva Sucursal</a>
                </div>
            </div>
            
            <div class="kpi-grid">
                <div class="kpi-card mint">
                    <div class="kpi-label">Total</div>
                    <div class="kpi-value"><?php echo $totalSucursales; ?></div>
                </div>
            </div>
            
            <div class="data-card">
                <div class="data-card-header">
                    <div class="data-card-title">Lista de Sucursales</div>
                </div>
                <?php if (!empty($sucursales)) { ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sucursales as $sucursal) { ?>
                        <tr>
                            <td><?php echo $sucursal->cod; ?></td>
                            <td><?php echo htmlspecialchars($sucursal->nombre); ?></td>
                            <td><?php echo htmlspecialchars($sucursal->direccion); ?></td>
                            <td><?php echo htmlspecialchars($sucursal->nroTelefono); ?></td>
                            <td>
                                <span class="badge <?php echo $sucursal->estado === 'activo' ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo $sucursal->estado; ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Sucursal/c-sucursal-edit.php?cod=<?php echo $sucursal->cod; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="<?php echo $baseUrl; ?>/control/Sucursal/c-sucursal-delete.php?cod=<?php echo $sucursal->cod; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta sucursal?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                <div class="empty-state">
                    <div class="empty-state-icon">🏪</div>
                    <div class="empty-state-text">No hay sucursales registradas</div>
                    <a href="<?php echo $baseUrl; ?>/control/Sucursal/c-sucursal-new.php" class="btn btn-primary mt-4">+ Agregar Primera Sucursal</a>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>