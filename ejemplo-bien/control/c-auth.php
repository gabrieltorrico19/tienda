<?php
session_start();

require_once "../model/RN_Usuario.php";

$oRN_Usuario = new RN_Usuario();

// Recuperamos los datos del form
$user = $_POST['user'];
$pass = $_POST['pass'];

$res = $oRN_Usuario->Verificar($user, $pass);

if ( $res != false) {
    // Autenticación exitosa    
    $_SESSION['AGROVET4'] = array("Key" => base64_encode($res));
} else {
    // Autenticación fallida
    $error = "Usuario o contraseña incorrectos.";
}

header("Location: ../index.php");

?>