<?php

require_once "../model/RN_Perfil.php";

$oRN_Perfil = new RN_Perfil();

$oPerfil = new Perfil(0, "", "Gerente", "", "Activo");

$res = $oRN_Perfil->Save($oPerfil);
if ($res){
    echo "Perfil guardado correctamente.";
}

?>