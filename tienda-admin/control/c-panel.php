<?php

session_start();
require_once "config.php";

if (!isset($_SESSION['AGROVET4'])) {
    header("Location: c-login.php");
    exit();
}

include_once "../view/v-panel.php";



?>