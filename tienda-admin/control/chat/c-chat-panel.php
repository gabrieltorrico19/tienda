<?php

session_start();
require_once "../config.php";
require_once "../../model/chat/ChatAdminModelo.php";

$adminUsuario = base64_decode($_SESSION['AGROVET4']['Key']);

$model = new ChatAdminModelo();
$model->Open();
$conversaciones = $model->ObtenerConversaciones($adminUsuario);

include_once "../../view/chat/v-chat-panel.php";
