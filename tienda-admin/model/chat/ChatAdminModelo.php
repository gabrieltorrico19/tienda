<?php

require_once __DIR__ . "/../data/DB.php";

class ChatAdminModelo extends DataBase
{
    function ObtenerConversaciones($adminUsuario)
    {
        $sql = "SELECT c.id, c.cliente_ci, c.estado, c.fechaInicio, c.fechaFin,
                       (SELECT contenido FROM Mensaje WHERE conversacion_id = c.id ORDER BY fechaHora DESC LIMIT 1) AS ultimo_mensaje,
                       (SELECT COUNT(*) FROM Mensaje WHERE conversacion_id = c.id AND leido = 0 AND tipo = 'cliente') AS mensajes_sin_leer
                FROM Conversacion c
                WHERE c.admin_usuario = '$adminUsuario'
                ORDER BY c.fechaInicio DESC";
        $res = $this->Execute($sql);
        return $this->DataListStructure($res);
    }

    function ObtenerMensajes($conversacionId)
    {
        $sql = "SELECT id, remitente, tipo, contenido, leido, fechaHora 
               FROM Mensaje 
               WHERE conversacion_id = $conversacionId 
               ORDER BY fechaHora ASC";
        $res = $this->Execute($sql);
        return $this->DataListStructure($res);
    }

    function MarcarLeidos($conversacionId, $remitente)
    {
        $sql = "UPDATE Mensaje SET leido = 1 
                WHERE conversacion_id = $conversacionId AND remitente != '$remitente' AND leido = 0";
        return $this->Execute($sql);
    }

    function getMensajesCount($conversacionId)
    {
        $sql = "SELECT COUNT(*) as total FROM Mensaje WHERE conversacion_id = $conversacionId";
        $res = $this->Execute($sql);
        $row = $this->FetchArray($res);
        return $row['total'];
    }

    function CerrarConversacion($conversacionId)
    {
        $sql = "UPDATE Conversacion SET estado = 'cerrada', fechaFin = NOW() WHERE id = $conversacionId";
        return $this->Execute($sql);
    }
}