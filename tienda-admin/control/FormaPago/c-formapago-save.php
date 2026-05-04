<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_FormaPago.php";

$nombre = trim($_POST["nombre"] ?? "");
$estado = $_POST["estado"] ?? "activa";

if ($nombre === "") {
    $error = "El nombre es obligatorio.";
    include __DIR__ . "/../../view/FormaPago/v-formapago-new.php";
    exit();
}

$oRN_FormaPago = new RN_FormaPago();
$oForma = new FormaPago(0, $nombre, $estado);
$oRN_FormaPago->Save($oForma);

header("Location: c-formapago-list.php");
exit();

?>