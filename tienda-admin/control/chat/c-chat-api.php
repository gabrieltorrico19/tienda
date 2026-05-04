<?php

require_once "../../model/chat/ChatAdminModelo.php";

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        listConversations();
        break;
    case 'messages':
        getMessages();
        break;
    case 'send':
        sendMessage();
        break;
    case 'mark':
        markAsRead();
        break;
    case 'close':
        closeConversation();
        break;
    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}

function listConversations()
{
    $adminUsuario = $_GET['admin'] ?? 'admin';

    $model = new ChatAdminModelo();
    $model->Open();
    $conversaciones = $model->ObtenerConversaciones($adminUsuario);

    echo json_encode(['conversaciones' => $conversaciones]);
}

function getMessages()
{
    $conversacionId = $_GET['conversacion_id'] ?? 0;

    if (!$conversacionId) {
        echo json_encode(['error' => 'Falta conversacion_id']);
        return;
    }

    $model = new ChatAdminModelo();
    $model->Open();
    $mensajes = $model->ObtenerMensajes($conversacionId);

    echo json_encode(['mensajes' => $mensajes]);
}

function sendMessage()
{
    $conversacionId = $_POST['conversacion_id'] ?? 0;
    $remitente = $_POST['remitente'] ?? '';
    $contenido = $_POST['contenido'] ?? '';

    if (!$conversacionId || !$contenido) {
        echo json_encode(['error' => 'Faltan parámetros']);
        return;
    }

    $model = new ChatAdminModelo();
    $model->Open();
    
    $sql = "INSERT INTO Mensaje (conversacion_id, remitente, tipo, contenido) 
            VALUES ($conversacionId, '$remitente', 'admin', '$contenido')";
    $model->Execute($sql);

    echo json_encode(['success' => true]);
}

function markAsRead()
{
    $conversacionId = $_GET['conversacion_id'] ?? 0;
    $remitente = $_GET['remitente'] ?? '';

    if (!$conversacionId) {
        echo json_encode(['error' => 'Falta conversacion_id']);
        return;
    }

    $model = new ChatAdminModelo();
    $model->Open();
    $model->MarcarLeidos($conversacionId, $remitente);

    echo json_encode(['success' => true]);
}

function closeConversation()
{
    $conversacionId = $_POST['conversacion_id'] ?? 0;

    if (!$conversacionId) {
        echo json_encode(['error' => 'Falta conversacion_id']);
        return;
    }

    $model = new ChatAdminModelo();
    $model->Open();
    $model->CerrarConversacion($conversacionId);

    echo json_encode(['success' => true]);
}