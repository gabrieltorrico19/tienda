<?php
$moduleName = $moduleName ?? 'Dashboard';
$moduleIcon = $moduleIcon ?? '📊';
$totalCount = $totalCount ?? 0;
$activeCount = $activeCount ?? 0;
$inactiveCount = $inactiveCount ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $moduleName; ?> - Admin</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/view/css/main.css">
</head>
<body>
    <button class="mobile-toggle" onclick="toggleSidebar()">☰</button>
    
    <div class="admin-layout">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-brand">
                    <span>🌿</span> Tienda Admin
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <div class="nav-section">Principal</div>
                <a href="<?php echo $baseUrl; ?>/control/admin/c-admin-panel.php" class="nav-item <?php echo $moduleName === 'Dashboard' ? 'active' : ''; ?>">
                    <span class="icon">📊</span> Dashboard
                </a>
                
                <div class="nav-section">Gestión</div>
                <a href="<?php echo $baseUrl; ?>/control/Producto/c-producto-list.php" class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'Producto') !== false ? 'active' : ''; ?>">
                    <span class="icon">📦</span> Productos
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Categoria/c-categoria-list.php" class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'Categoria') !== false ? 'active' : ''; ?>">
                    <span class="icon">🏷️</span> Categorías
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Marca/c-marca-list.php" class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'Marca') !== false ? 'active' : ''; ?>">
                    <span class="icon">🏅</span> Marcas
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Industria/c-industria-list.php" class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'Industria') !== false ? 'active' : ''; ?>">
                    <span class="icon">🏭</span> Industrias
                </a>
                <a href="<?php echo $baseUrl; ?>/control/FormaPago/c-formapago-list.php" class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'FormaPago') !== false ? 'active' : ''; ?>">
                    <span class="icon">💳</span> Formas de Pago
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Sucursal/c-sucursal-list.php" class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'Sucursal') !== false ? 'active' : ''; ?>">
                    <span class="icon">🏪</span> Sucursales
                </a>
                <a href="<?php echo $baseUrl; ?>/control/Inventario/c-inventario-list.php" class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'Inventario') !== false ? 'active' : ''; ?>">
                    <span class="icon">📋</span> Inventario
                </a>
                
                <div class="nav-section">Comunicación</div>
                <a href="<?php echo $baseUrl; ?>/control/chat/c-chat-panel.php" class="nav-item <?php echo strpos($_SERVER['REQUEST_URI'], 'chat') !== false ? 'active' : ''; ?>">
                    <span class="icon">💬</span> Chat
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <a href="<?php echo $baseUrl; ?>/control/auth/c-login.php" class="logout-btn">
                    <span class="icon">🚪</span> Cerrar Sesión
                </a>
            </div>
        </aside>
        
        <main class="main-content">