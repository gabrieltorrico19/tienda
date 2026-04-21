<?php

require_once "data/DetalleProductoSucursal.php";
require_once "data/DB.php";

class RN_DetalleProductoSucursal extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList()
    {
        $res = $this->Execute("CALL sp_DetalleProductoSucursalListar()");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new DetalleProductoSucursal(
                    $item["codProducto"],
                    $item["codSucursal"],
                    $item["stock"],
                    $item["stockMinimo"],
                    $item["fechaActualizacion"]
                );
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($codProducto, $codSucursal)
    {
        $res = $this->Execute("CALL sp_DetalleProductoSucursalObtener(" . intval($codProducto) . "," .
            intval($codSucursal) . ")");
        $oDetalle = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oDetalle = new DetalleProductoSucursal(
                    $item["codProducto"],
                    $item["codSucursal"],
                    $item["stock"],
                    $item["stockMinimo"],
                    $item["fechaActualizacion"]
                );
            }
        }

        $this->ClearResults($res);
        return $oDetalle;
    }

    function GetInventarioBySucursal($codSucursal)
    {
        $res = $this->Execute("CALL sp_ConsultarInventario(" . intval($codSucursal) . ")");
        $data = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
        }

        $this->ClearResults($res);
        return $data;
    }

    function Save($oDetalle)
    {
        $res = $this->Execute("CALL sp_ActualizarStock(" . intval($oDetalle->codProducto) . "," .
            intval($oDetalle->codSucursal) . "," . intval($oDetalle->stock) . ")");
        $this->ClearResults($res);
        return $res;
    }

    function Update($oDetalle)
    {
        return $this->Save($oDetalle);
    }

    function SaveWithMinimo($codProducto, $codSucursal, $stock, $stockMinimo)
    {
        $sql = "INSERT INTO DetalleProductoSucursal (codProducto, codSucursal, stock, stockMinimo) VALUES (" .
            intval($codProducto) . "," . intval($codSucursal) . "," . intval($stock) . "," . intval($stockMinimo) . ") " .
            "ON DUPLICATE KEY UPDATE stock = VALUES(stock), stockMinimo = VALUES(stockMinimo), " .
            "fechaActualizacion = CURRENT_TIMESTAMP";

        $res = $this->Execute($sql);
        $this->ClearResults($res);
        return $res;
    }

    function Delete($codProducto, $codSucursal)
    {
        $res = $this->Execute("CALL sp_ActualizarStock(" . intval($codProducto) . "," .
            intval($codSucursal) . ",0)");
        $this->ClearResults($res);
        return $res;
    }
}

?>