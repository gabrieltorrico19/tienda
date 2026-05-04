<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Producto.php";

$cod = isset($_GET["cod"]) ? (int)$_GET["cod"] : 0;

$oRN_Producto = new RN_Producto();
$oRN_Producto->Delete($cod);

header("Location: c-producto-list.php");
exit();
