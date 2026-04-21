<?php

require_once "../model/RN_Perfil.php";
require_once "../model/RN_Usuario.php";

$oRN_Perfil = new RN_Perfil();
$oRN_Usuario = new RN_Usuario();

$lista = $oRN_Perfil->GetList();
echo "Total de perfiles: " . count($lista) . "<br>";
/*
foreach ($lista as $oPerfil) {
    echo "<hr>";
    echo "ID Perfil: " . $oPerfil->idPerfil . "<br>";
    echo "Hash Perfil: " . $oPerfil->hashPerfil . "<br>";
    echo "Nombre: " . $oPerfil->nombre . "<br>";
    echo "Descripción: " . $oPerfil->descripcion . "<br>";
    echo "Estado: " . $oPerfil->estado;
}*/

$listaUsuario = $oRN_Usuario->GetList();
foreach($listaUsuario as $oUsuario){
    echo "<hr>";
    echo "ID Usuario: " . $oUsuario->idUsuario . "<br>";
    echo "Hash Usuario: " . $oUsuario->hashUsuario . "<br>";
    echo "Nombre: " . $oUsuario->nombre . "<br>";
    echo "Username: " . $oUsuario->username . "<br>";
    echo "Password: " . $oUsuario->pswd . "<br>";
    echo "ID Perfil: " . $oUsuario->idPerfil . "<br>";
    echo "Estado: " . $oUsuario->estado;
}

echo "<hr>";
$hashUsuario = sha1(1);

$oUsuario2 = $oRN_Usuario->GetData($hashUsuario);
echo "Nombre: " . $oUsuario2->nombre . "<br>";
echo "Username: " . $oUsuario2->username . "<br>";
echo "Password: " . $oUsuario2->pswd . "<br>";

?>