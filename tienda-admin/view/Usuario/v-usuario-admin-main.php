<?php
if (!isset($totalAdmins)) {
    $totalAdmins = is_array($admins ?? null) ? count($admins) : 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administradores - Admin</title>
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
                <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-list.php" class="nav-item">
                    <span class="nav-icon">📋</span> Inventario
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Usuario/c-usuario-admin-list.php" class="nav-item active">
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
                    <div class="page-title-icon">🛡️</div>
                    Administradores
                </div>
                <div class="page-actions">
                    <a href="<?php echo $baseUrl; ?>/control/Usuario/c-usuario-admin-new.php" class="btn btn-primary">+ Nuevo Admin</a>
                </div>
            </div>
            <div class="kpi-grid">
                <div class="kpi-card mint">
                    <div class="kpi-label">Total</div>
                    <div class="kpi-value"><?php echo $totalAdmins; ?></div>
                </div>
            </div>
            <div class="data-card">
                <div class="data-card-header">
                    <div class="data-card-title">Lista de Administradores</div>
                </div>
                <?php if (!empty($admins)) { ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($admins as $admin) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($admin->usuario); ?></td>
                            <td><?php echo htmlspecialchars($admin->email); ?></td>
                            <td>
                                <span class="badge <?php echo $admin->estado === 'activo' ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo $admin->estado; ?>
                                </span>
                            </td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Usuario/c-usuario-admin-edit.php?usuario=<?php echo urlencode($admin->usuario); ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="<?php echo $baseUrl; ?>/control/Usuario/c-usuario-admin-delete.php?usuario=<?php echo urlencode($admin->usuario); ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este administrador?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                <div class="empty-state">
                    <div class="empty-state-icon">🛡️</div>
                    <div class="empty-state-text">No hay administradores registrados</div>
                    <a href="<?php echo $baseUrl; ?>/control/Usuario/c-usuario-admin-new.php" class="btn btn-primary mt-4">+ Agregar Primer Admin</a>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>
