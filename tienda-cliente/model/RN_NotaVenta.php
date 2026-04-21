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
                    $item["nro"],
                    $item["fechaHora"],
                    $item["ciCliente"],
                    $item["totalVenta"],
                    $item["estado"],
                    $item["observaciones"]
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
                    $item["nro"],
                    $item["fechaHora"],
                    $item["ciCliente"],
                    $item["totalVenta"],
                    $item["estado"],
                    $item["observaciones"]
                );
            }
        }

        $this->ClearResults($res);
        return $oNota;
    }

    function InsertarVenta($ciCliente, $observaciones)
    {
        $sql = "CALL sp_InsertarVenta('" . addslashes($ciCliente) . "','" . addslashes($observaciones) . "',@p_nro)";
        $res = $this->Execute($sql);
        $this->ClearResults($res);

        $resId = $this->Execute("SELECT @p_nro AS nro");
        $id = 0;
        if ($this->ContainsData($resId)) {
            $row = $this->FetchArray($resId);
            if ($row && isset($row["nro"])) {
                $id = (int)$row["nro"];
            }
        }
        $this->ClearResults($resId);

        return $id;
    }

    function ActualizarEstado($nro, $estado)
    {
        $res = $this->Execute("CALL sp_NotaVentaActualizarEstado(" . intval($nro) . ",'" .
              addslashes($estado) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function CompletarVenta($nroVenta, $codSucursal)
    {
        $res = $this->Execute("CALL sp_CompletarVenta(" . intval($nroVenta) . "," .
            intval($codSucursal) . ")");
        $this->ClearResults($res);
        return $res;
    }
}

?>