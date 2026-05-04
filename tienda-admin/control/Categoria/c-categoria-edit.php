<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Categoria.php";

$cod = isset($_GET["cod"]) ? (int)$_GET["cod"] : 0;

$oRN_Categoria = new RN_Categoria();
$oCategoria = $oRN_Categoria->GetData($cod);

if ($oCategoria === null) {
    header("Location: c-categoria-list.php");
    exit();
}

include __DIR__ . "/../../view/Categoria/v-categoria-edit.php";
