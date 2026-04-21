<?php

require_once "../model/RN_Cliente.php";
require_once "../model/data/Cliente.php";

$oRN_Cliente = new RN_Cliente();

$oCliente = new Cliente(
    "12345678",
    "Cliente",
    "Prueba",
    "Demo",
    "cliente@example.com",
    "Sin direccion",
    "70000000",
    "cliente_demo",
    date("Y-m-d H:i:s"),
    "activo"
);

$res = $oRN_Cliente->Save($oCliente);
if ($res) {
    echo "Cliente guardado correctamente.";
}

?>