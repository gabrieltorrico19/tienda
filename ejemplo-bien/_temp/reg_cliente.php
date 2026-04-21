<?php

require_once "../model/RN_Cliente.php";

$oRN_Cliente = new RN_Cliente();

$oCliente = new Cliente(0, "", "Cliente Prueba", "12345678", "Sin direccion", "Activo");

$res = $oRN_Cliente->Save($oCliente);
if ($res){
    echo "Cliente guardado correctamente.";
}

?>
