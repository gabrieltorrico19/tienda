<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../auth/c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../../model/RN_Cuenta.php";
require_once __DIR__ . "/../../model/data/Cuenta.php";

$usuario = trim($_POST["usuario"] ?? "");
$password = trim($_POST["password"] ?? "");
$email = trim($_POST["email"] ?? "");
$estado = trim($_POST["estado"] ?? "activo");

if ($usuario === "" || $password === "" || $email === "") {
    $error = "Usuario, correo y contraseña son obligatorios.";
    include __DIR__ . "/../../view/Usuario/v-usuario-admin-new.php";
    exit();
}

$oRN_Cuenta = new RN_Cuenta();
$oCuenta = new Cuenta($usuario, $password, $email, date("Y-m-d"), $estado);
$oRN_Cuenta->Save($oCuenta);

header("Location: c-usuario-admin-list.php");
exit();
