<?php

require_once "../../model/RN_Cliente.php";
require_once "../../model/RN_Cuenta.php";
require_once "../../model/data/Cliente.php";
require_once "../../model/data/Cuenta.php";

session_start();

$error = "";
$next = $_POST["next"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ci = trim($_POST["ci"] ?? "");
    $nombres = trim($_POST["nombres"] ?? "");
    $apPaterno = trim($_POST["apPaterno"] ?? "");
    $apMaterno = trim($_POST["apMaterno"] ?? "");
    $correo = trim($_POST["correo"] ?? "");
    $direccion = trim($_POST["direccion"] ?? "");
    $nroCelular = trim($_POST["nroCelular"] ?? "");
    $usuario = trim($_POST["usuario"] ?? "");
    $password = $_POST["password"] ?? "";
    $password2 = $_POST["password2"] ?? "";

    if (empty($ci) || empty($nombres) || empty($apPaterno) || empty($correo) || empty($nroCelular) || empty($usuario) || empty($password)) {
        $error = "Por favor, completa todos los campos obligatorios.";
    } elseif ($password !== $password2) {
        $error = "Las contraseñas no coinciden.";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        $oCuenta = new RN_Cuenta();
        $oCliente = new RN_Cliente();

        $existeCuenta = $oCuenta->GetData($usuario);
        if ($existeCuenta) {
            $error = "El usuario ya existe. Elige otro nombre de usuario.";
        } else {
            try {
                $oCuenta->Save(new Cuenta($usuario, $password, $correo, date("Y-m-d H:i:s"), "activo"));

                $oCliente->Save(new Cliente(
                    $ci,
                    $nombres,
                    $apPaterno,
                    $apMaterno,
                    $correo,
                    $direccion,
                    $nroCelular,
                    $usuario,
                    date("Y-m-d H:i:s"),
                    "activo"
                ));

                header("Location: v-login.php?registered=1&next=" . urlencode($next));
                exit;
            } catch (Exception $e) {
                $error = "Error al registrar: " . $e->getMessage();
            }
        }
    }
}

require_once "v-register.php";