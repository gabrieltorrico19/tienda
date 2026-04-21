<?php

/**
 * @author		Miguel Angel Macias Burgos
 * @company 	WBT
 * @copyright 	2026
 * @version     1.0
 */

$nomUsuario = $oUsuario->nombre;

$title = "Panel Principal";

$menu = "";
$menu .= "<a href='TiposPizzas/c-tipospizzas-list.php'>
            <div class='menu-item'>
                <div class='menu-item-pic ico-1'></div>
                <div class='menu-item-title'>Tipos de Pizzas</div>
                <div class='clear'></div>
            </div>
        </a>";

$menu .= "<a href='Tamanho/c-tamanho-list.php'>
            <div class='menu-item'>
                <div class='menu-item-pic ico-2'></div>
                <div class='menu-item-title'>Tamaños</div>
                <div class='clear'></div>
            </div>
        </a>";

$menu .= "<a href='Tarifas/c-tarifas-list.php'>
            <div class='menu-item'>
                <div class='menu-item-pic ico-3'></div>
                <div class='menu-item-title'>Tarifas</div>
                <div class='clear'></div>
            </div>
        </a>";

$menu .= "<a href='venta/c-venta-list.php'>
            <div class='menu-item'>
                <div class='menu-item-pic ico-5'></div>
                <div class='menu-item-title'>Ventas</div>
                <div class='clear'></div>
            </div>
        </a>";

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv='content-type' content='text/html' charset='utf-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no' />
    
	<title><?php echo $appTitle; ?></title>
        
    <!-- CSS -->
    <link rel='stylesheet' href='../view/css/main.css' />
</head>

<body>

<!-- Main Page -->
<div class='ctn-form'>
    <!-- Header -->
    <div class='form-header'>
        <div class='ctn-icon'><div class='icon'></div></div>
        <div class='form-title'><?php echo $appTitle; ?></div>
        <div class='form-subtitle'>Bienvenido <?php echo $nomUsuario ?></div>
        <div class='bar'><div class='step'></div></div>        
        <a href='c-login.php'><div class='btn-back'></div></a>
    </div>
    <!-- Body -->
    <div class='form-content'>
        <div class='title'><?php echo $title ?></div>
        <div class='menu'>
            <?php echo $menu; ?>
        </div>
        <div class='clear'></div>

    </div>
</div>

</body>
</html>