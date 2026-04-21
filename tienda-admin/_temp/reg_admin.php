<?php

require_once "../model/RN_Cuenta.php";
require_once "../model/data/Cuenta.php";

$oRN_Cuenta = new RN_Cuenta();

$oCuenta = new Cuenta(
    "admin",
    "admin123",
    "admin@example.com",
    date("Y-m-d H:i:s"),
    "activo"
);

$res = $oRN_Cuenta->Save($oCuenta);
if ($res) {
    echo "Admin guardado correctamente.";
}

?>