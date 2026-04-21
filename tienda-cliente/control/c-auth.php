<?php
session_start();

require_once "../model/RN_Cuenta.php";
require_once "../model/RN_Cliente.php";

$oRN_Cuenta = new RN_Cuenta();
$oRN_Cliente = new RN_Cliente();

// Recuperamos los datos del form
$user = $_POST['user'];
$pass = $_POST['pass'];

$res = $oRN_Cuenta->Verificar($user, $pass);

if ($res != false) {
    $oCliente = $oRN_Cliente->GetDataByUsuario($res);
    if ($oCliente === null) {
        $_SESSION['LOGIN_ERROR'] = "El usuario no tiene cliente asociado.";
        header("Location: c-login.php");
        exit();
    }

    $_SESSION['CLIENTE_USER'] = $res;
    $_SESSION['CLIENTE_CI'] = $oCliente->ci;

    $next = $_POST['next'] ?? "";
    if ($next !== "") {
        header("Location: ../" . $next);
        exit();
    }

    header("Location: ../index.php");
    exit();
}

$_SESSION['LOGIN_ERROR'] = "Usuario o contraseña incorrectos.";
header("Location: c-login.php");
exit();

?>