<?php

require_once "data/FormaPago.php";
require_once "data/DB.php";

class RN_FormaPago extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList()
    {
        $res = $this->Execute("CALL sp_FormaPagoListar()");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new FormaPago(
                    $item["COD"] ?? 0,
                    $item["NOMBRE"] ?? "",
                    $item["ESTADO"] ?? "activa"
                );
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($cod)
    {
        $res = $this->Execute("CALL sp_FormaPagoObtener(" . intval($cod) . ")");
        $oForma = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oForma = new FormaPago(
                    $item["COD"] ?? 0,
                    $item["NOMBRE"] ?? "",
                    $item["ESTADO"] ?? "activa"
                );
            }
        }

        $this->ClearResults($res);
        return $oForma;
    }

    function Save($oForma)
    {
        $sql = "CALL sp_FormaPagoInsertar('" . addslashes($oForma->nombre) . "','" .
            addslashes($oForma->descripcion) . "','" . addslashes($oForma->estado) . "')";

        $res = $this->Execute($sql);
        $this->ClearResults($res);
        return $res;
    }

    function Update($oForma)
    {
        $sql = "CALL sp_FormaPagoActualizar(" . intval($oForma->cod) . ",'" .
            addslashes($oForma->nombre) . "','" . addslashes($oForma->descripcion) . "','" .
            addslashes($oForma->estado) . "')";

        $res = $this->Execute($sql);
        $this->ClearResults($res);
        return $res;
    }

    function Delete($cod)
    {
        $res = $this->Execute("CALL sp_FormaPagoEliminar(" . intval($cod) . ")");
        $this->ClearResults($res);
        return $res;
    }

    function AsignarFormaPago($nroNota, $codFormaPago)
    {
        $res = $this->Execute("CALL sp_NotaVentaAsignarFormaPago(" . intval($nroNota) . "," .
            intval($codFormaPago) . ")");
        $this->ClearResults($res);
        return $res;
    }
}

?>