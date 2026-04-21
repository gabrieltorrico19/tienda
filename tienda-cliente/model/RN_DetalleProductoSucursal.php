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

    function Delete($codProducto, $codSucursal)
    {
        $res = $this->Execute("CALL sp_ActualizarStock(" . intval($codProducto) . "," .
            intval($codSucursal) . ",0)");
        $this->ClearResults($res);
        return $res;
    }
}

?>