<?php

require_once __DIR__ . "/config-app.php";
require_once __DIR__ . "/../model/RN_Producto.php";

$productos = RN_Producto::listar();

include __DIR__ . "/../view/v-home.php";
