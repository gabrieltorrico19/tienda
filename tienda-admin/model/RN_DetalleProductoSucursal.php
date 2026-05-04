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
                    $item["CODPRODUCTO"] ?? 0,
                    $item["CODSUCURSAL"] ?? 0,
                    $item["STOCK"] ?? 0,
                    $item["STOCKMINIMO"] ?? 5,
                    $item["FECHAACTUALIZACION"] ?? date("Y-m-d")
                );
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($codProducto, $codSucursal)
    {
        $res = $this->Execute("CALL sp_DetalleProductoSucursalObtener(" . intval($codProducto) . "," . intval($codSucursal) . ")");
        $oDetalle = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oDetalle = new DetalleProductoSucursal(
                    $item["CODPRODUCTO"] ?? 0,
                    $item["CODSUCURSAL"] ?? 0,
                    $item["STOCK"] ?? 0,
                    $item["STOCKMINIMO"] ?? 5,
                    $item["FECHAACTUALIZACION"] ?? date("Y-m-d")
                );
            }
        }

        $this->ClearResults($res);
        return $oDetalle;
    }

    function GetInventario($codSucursal)
    {
        $res = $this->Execute("CALL sp_ConsultarInventario(" . intval($codSucursal) . ")");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = $item;
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetInventarioBySucursal($codSucursal)
    {
        return $this->GetInventario($codSucursal);
    }

    function Save($oDetalle)
    {
        $res = $this->Execute("CALL sp_ActualizarStock(" . intval($oDetalle->codProducto) . "," .
            intval($oDetalle->codSucursal) . "," . intval($oDetalle->stock) . "," .
            intval($oDetalle->stockMinimo) . ")");
        $this->ClearResults($res);
        return $res;
    }

    function UpdateStock($codProducto, $codSucursal, $stock, $stockMinimo)
    {
        $res = $this->Execute("CALL sp_ActualizarStock(" . intval($codProducto) . "," .
            intval($codSucursal) . "," . intval($stock) . "," . intval($stockMinimo) . ")");
        $this->ClearResults($res);
        return $res;
    }
}

?>