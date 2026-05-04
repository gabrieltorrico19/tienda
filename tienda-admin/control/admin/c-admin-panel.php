<?php

session_start();
require_once "../config.php";

if (!isset($_SESSION['AGROVET4'])) {
    header("Location: ../auth/c-login.php");
    exit();
}

$adminUsuario = base64_decode($_SESSION['AGROVET4']['Key']);

include_once "../../view/admin/v-admin-panel.php";



?>