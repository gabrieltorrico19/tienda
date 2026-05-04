<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Cuenta.php";
require_once __DIR__ . "/../../model/RN_Cliente.php";
require_once __DIR__ . "/../../model/data/Cuenta.php";
require_once __DIR__ . "/../../model/data/Cliente.php";

$ci = trim($_POST["ci"] ?? "");
$nombres = trim($_POST["nombres"] ?? "");
$apPaterno = trim($_POST["apPaterno"] ?? "");
$apMaterno = trim($_POST["apMaterno"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$direccion = trim($_POST["direccion"] ?? "");
$nroCelular = trim($_POST["nroCelular"] ?? "");
$usuario = trim($_POST["usuario"] ?? "");
$password = trim($_POST["password"] ?? "");
$estado = trim($_POST["estado"] ?? "activo");

if ($ci === "" || $nombres === "" || $apPaterno === "" || $apMaterno === "" || $correo === "" || $direccion === "" || $nroCelular === "" || $usuario === "" || $password === "") {
    $error = "Todos los campos son obligatorios.";
    include __DIR__ . "/../../view/Usuario/v-usuario-cliente-new.php";
    exit();
}

$oRN_Cuenta = new RN_Cuenta();
$oRN_Cliente = new RN_Cliente();

$oCuenta = new Cuenta($usuario, $password, $correo, date("Y-m-d"), $estado);
$oRN_Cuenta->Save($oCuenta);

$oCliente = new Cliente($ci, $nombres, $apPaterno, $apMaterno, $correo, $direccion, $nroCelular, $usuario, date("Y-m-d"), $estado);
$oRN_Cliente->Save($oCliente);

header("Location: c-usuario-cliente-list.php");
exit();
