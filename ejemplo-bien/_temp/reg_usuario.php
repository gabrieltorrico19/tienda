<?php

require_once "../model/RN_Usuario.php";

$oRN_Usuario = new RN_Usuario();

$oUsuario = new Usuario(0, "", "macbur", "macbur", "000", 1, "Activo");

$res = $oRN_Usuario->Save($oUsuario);
if ($res){
    echo "Usuario guardado correctamente.";
}

?>