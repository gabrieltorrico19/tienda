<?php

require_once __DIR__ . "/config-app.php";
require_once __DIR__ . "/../model/RN_Usuario.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"] ?? "";
    $password = $_POST["password"] ?? "";

    if (RN_Usuario::validarAdmin($usuario, $password)) {
        $_SESSION["admin"] = $usuario;
        header("Location: c-admin-panel.php");
        exit();
    }

    $error = "Usuario o contrasena incorrectos.";
}

include __DIR__ . "/../view/admin/v-login.php";
