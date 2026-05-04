<?php
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/tienda/tienda-admin';

require_once __DIR__ . "/../../model/RN_Marca.php";

$oRN_Marca = new RN_Marca();
$marcas = $oRN_Marca->GetList();

$totalMarcas = count($marcas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcas - Admin</title>
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
                <a href="<?php echo $baseUrl; ?>/control/Marca/c-marca-list.php" class="nav-item active">
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
                    <div class="page-title-icon">🏅</div>
                    Marcas
                </div>
                <div class="page-actions">
                    <a href="<?php echo $baseUrl; ?>/control/Marca/c-marca-new.php" class="btn btn-primary">+ Nueva Marca</a>
                </div>
            </div>
            
            <div class="kpi-grid">
                <div class="kpi-card mint">
                    <div class="kpi-label">Total</div>
                    <div class="kpi-value"><?php echo $totalMarcas; ?></div>
                </div>
            </div>
            
            <div class="data-card">
                <div class="data-card-header">
                    <div class="data-card-title">Lista de Marcas</div>
                </div>
                <?php if (!empty($marcas)) { ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($marcas as $marca) { ?>
                        <tr>
                            <td><?php echo $marca->cod; ?></td>
                            <td><?php echo htmlspecialchars($marca->nombre); ?></td>
                            <td><?php echo htmlspecialchars($marca->descripcion); ?></td>
                            <td class="actions">
                                <a href="<?php echo $baseUrl; ?>/control/Marca/c-marca-edit.php?cod=<?php echo $marca->cod; ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="<?php echo $baseUrl; ?>/control/Marca/c-marca-delete.php?cod=<?php echo $marca->cod; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta marca?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php } else { ?>
                <div class="empty-state">
                    <div class="empty-state-icon">🏅</div>
                    <div class="empty-state-text">No hay marcas registradas</div>
                    <a href="<?php echo $baseUrl; ?>/control/Marca/c-marca-new.php" class="btn btn-primary mt-4">+ Agregar Primera Marca</a>
                </div>
                <?php } ?>
            </div>
        </main>
    </div>
</body>
</html>
