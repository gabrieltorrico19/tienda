<?php
session_start();

require_once "../../model/RN_Cuenta.php";

$oRN_Cuenta = new RN_Cuenta();

// Recuperamos los datos del form
$user = $_POST['user'];
$pass = $_POST['pass'];

$res = $oRN_Cuenta->Verificar($user, $pass);

if ($res != false) {
    // Autenticación exitosa
    $_SESSION['AGROVET4'] = array("Key" => base64_encode($res));
    header("Location: ../admin/c-admin-panel.php");
    exit();
}

// Autenticación fallida
$_SESSION['LOGIN_ERROR'] = "Usuario o contraseña incorrectos.";
header("Location: c-login.php");
exit();

?>