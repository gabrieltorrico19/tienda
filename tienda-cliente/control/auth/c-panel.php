<?php

session_start();
require_once "../model/RN_Usuario.php";
require_once "../../config.php";

$oRN_Usuario = new RN_Usuario();

if (isset($_SESSION['AGROVET4'])) {
    $data = $_SESSION['AGROVET4']; // return array
    $hashUsuario = base64_decode($data["Key"]);

    //$hashUsuario = base64_decode($_SESSION['AGROVET4']['Key']);
    $oUsuario = $oRN_Usuario->GetData($hashUsuario);
    include_once "../view/auth/v-panel.php";
}



?>