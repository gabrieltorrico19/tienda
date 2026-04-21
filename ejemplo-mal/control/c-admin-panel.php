<?php

require_once __DIR__ . "/config-app.php";

session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: c-admin-login.php");
    exit();
}

include __DIR__ . "/../view/admin/v-panel.php";
