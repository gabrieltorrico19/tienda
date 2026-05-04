<?php

require_once "../../model/chat/ChatModelo.php";

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'init':
        initConversation();
        break;
    case 'send':
        sendMessage();
        break;
    case 'poll':
        pollMessages();
        break;
    case 'check':
        checkNewMessages();
        break;
    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}

function initConversation()
{
    $clienteCi = $_POST['cliente_ci'] ?? '';
    $adminUsuario = $_POST['admin'] ?? 'admin';

    if (!$clienteCi) {
        echo json_encode(['error' => 'Falta cliente_ci']);
        return;
    }

    $model = new ChatModelo();
    $model->Open();
    $conversacionId = $model->ObtenerOMostarCrearConversacion($clienteCi, $adminUsuario);

    echo json_encode(['success' => true, 'conversacion_id' => $conversacionId]);
}

function sendMessage()
{
    $conversacionId = $_POST['conversacion_id'] ?? 0;
    $remitente = $_POST['remitente'] ?? '';
    $tipo = $_POST['tipo'] ?? 'cliente';
    $contenido = $_POST['contenido'] ?? '';

    if (!$conversacionId || !$contenido) {
        echo json_encode(['error' => 'Faltan parámetros']);
        return;
    }

    $model = new ChatModelo();
    $model->Open();
    $model->EnviarMensaje($conversacionId, $remitente, $tipo, $contenido);

    echo json_encode(['success' => true]);
}

function pollMessages()
{
    $conversacionId = $_GET['conversacion_id'] ?? 0;
    $desdeId = $_GET['desde_id'] ?? 0;

    if (!$conversacionId) {
        echo json_encode(['error' => 'Falta conversacion_id']);
        return;
    }

    $model = new ChatModelo();
    $model->Open();
    $mensajes = $model->ObtenerMensajes($conversacionId, $desdeId);

    echo json_encode(['mensajes' => $mensajes]);
}

function checkNewMessages()
{
    $conversacionId = $_GET['conversacion_id'] ?? 0;
    $remitente = $_GET['remitente'] ?? '';

    if (!$conversacionId) {
        echo json_encode(['error' => 'Falta conversacion_id']);
        return;
    }

    $model = new ChatModelo();
    $model->Open();
    $model->MarcarLeidos($conversacionId, $remitente);
    $count = $model->getMensajesCount($conversacionId);

    echo json_encode(['count' => $count]);
}