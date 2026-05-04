<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Categoria.php";

$oRN_Categoria = new RN_Categoria();
$categorias = $oRN_Categoria->GetList();

include __DIR__ . "/../../view/Categoria/v-categoria-main.php";
