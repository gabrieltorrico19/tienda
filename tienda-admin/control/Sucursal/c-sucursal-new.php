<?php

session_start();
if (!isset($_SESSION["AGROVET4"])) {
    header("Location: ../c-login.php");
    exit();
}

require_once __DIR__ . "/../config.php";

include __DIR__ . "/../../view/Sucursal/v-sucursal-new.php";
