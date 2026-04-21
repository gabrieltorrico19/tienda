<?php

require_once __DIR__ . "/../config.php";

session_start();
$clienteUsuario = $_SESSION['CLIENTE_USER'] ?? null;

include __DIR__ . "/../../view/tienda/v-payment-success.php";
