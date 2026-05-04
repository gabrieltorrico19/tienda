<?php

require_once "data/NotaVenta.php";
require_once "data/DB.php";

class RN_NotaVenta extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList()
    {
        $res = $this->Execute("CALL sp_NotaVentaListar()");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new NotaVenta(
                    $item["NRO"] ?? 0,
                    $item["FECHAHORA"] ?? date("Y-m-d H:i:s"),
                    $item["CI"] ?? "",
                    $item["TOTALVENTA"] ?? 0,
                    $item["ESTADO"] ?? "pendiente",
                    $item["OBSERVACIONES"] ?? ""
                );
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($nro)
    {
        $res = $this->Execute("CALL sp_NotaVentaObtener(" . intval($nro) . ")");
        $oNota = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oNota = new NotaVenta(
                    $item["NRO"] ?? 0,
                    $item["FECHAHORA"] ?? date("Y-m-d H:i:s"),
                    $item["CI"] ?? "",
                    $item["TOTALVENTA"] ?? 0,
                    $item["ESTADO"] ?? "pendiente",
                    $item["OBSERVACIONES"] ?? ""
                );
            }
        }

        $this->ClearResults($res);
        return $oNota;
    }

    function Save($ciCliente, $observaciones)
    {
        $res = $this->Execute("CALL sp_InsertarVenta('" . addslashes($ciCliente) . "','" . addslashes($observaciones) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function UpdateEstado($nro, $estado)
    {
        $res = $this->Execute("CALL sp_NotaVentaActualizarEstado(" . intval($nro) . ",'" . addslashes($estado) . "')");
        $this->ClearResults($res);
        return $res;
    }
}

?>