<?php
if (!isset($totalFormas)) {
    $totalFormas = is_array($formasPago ?? null) ? count($formasPago) : 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formas de Pago - Admin</title>
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
                <a href="<?php echo $baseUrl; ?>/control/FormaPago/c-formapago-list.php" class="nav-item active">
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
                    <div class="page-title-icon">💳</div>
                    Formas de Pago
                </div>
                <div class="page-actions">
                    <a href="<?php echo $baseUrl; ?>/control/FormaPago/c-formapago-new.php" class="btn btn-primary">+ Nueva Forma de Pago</a>
                </div>
            </div>
            
            <div class="kpi-grid">
                <div class="kpi-card mint">
                    <div class="kpi-label">Total</div>
                    <div class="kpi-value"><?php echo $totalFormas; ?></div>
                </div>
            </div>
            
            <div class="data-card">
                <div class="data-card-header">
                    <div class="data-card-title">Lista de Formas de Pago</div>
                </div>
                <?php if (!empty($formasPago)) { ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($formasPago as $forma) { ?>
                        <tr>
                            <td><?php echo $forma->cod; ?></td>
                            <td><?php echo htmlspecialchars($forma->nombre); ?></td>
                            <td>
                                <span class="badge <?php echo $forma->estado === 'activa' ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo $forma->estado; ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/FormaPago/c-formapago-edit.php?cod=<?php echo $forma->cod; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="<?php echo $baseUrl; ?>/control/FormaPago/c-formapago-delete.php?cod=<?php echo $forma->cod; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta forma de pago?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                <div class="empty-state">
                    <div class="empty-state-icon">💳</div>
                    <div class="empty-state-text">No hay formas de pago registradas</div>
                    <a href="<?php echo $baseUrl; ?>/control/FormaPago/c-formapago-new.php" class="btn btn-primary mt-4">+ Agregar Primera Forma de Pago</a>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>
