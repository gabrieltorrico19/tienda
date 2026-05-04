<?php

require_once "data/Sucursal.php";
require_once "data/DB.php";

class RN_Sucursal extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList()
    {
        $res = $this->Execute("CALL sp_SucursalListar()");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new Sucursal(
                    $item["COD"] ?? 0,
                    $item["NOMBRE"] ?? "",
                    $item["DIRECCION"] ?? "",
                    $item["NROTELEFONO"] ?? "",
                    $item["ESTADO"] ?? "activa",
                    $item["FECHACREACION"] ?? date("Y-m-d")
                );
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($cod)
    {
        $res = $this->Execute("CALL sp_SucursalObtener(" . intval($cod) . ")");
        $oSucursal = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oSucursal = new Sucursal(
                    $item["COD"] ?? 0,
                    $item["NOMBRE"] ?? "",
                    $item["DIRECCION"] ?? "",
                    $item["NROTELEFONO"] ?? "",
                    $item["ESTADO"] ?? "activa",
                    $item["FECHACREACION"] ?? date("Y-m-d")
                );
            }
        }

        $this->ClearResults($res);
        return $oSucursal;
    }

    function Save($oSucursal)
    {
        $res = $this->Execute("CALL sp_SucursalInsertar('" . addslashes($oSucursal->nombre) . "','" .
            addslashes($oSucursal->direccion) . "','" . addslashes($oSucursal->nroTelefono) . "','" .
            addslashes($oSucursal->estado) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Update($oSucursal)
    {
        $res = $this->Execute("CALL sp_SucursalActualizar(" . intval($oSucursal->cod) . ",'" .
            addslashes($oSucursal->nombre) . "','" . addslashes($oSucursal->direccion) . "','" .
            addslashes($oSucursal->nroTelefono) . "','" . addslashes($oSucursal->estado) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Delete($cod)
    {
        $res = $this->Execute("CALL sp_SucursalEliminar(" . intval($cod) . ")");
        $this->ClearResults($res);
        return $res;
    }
}

?>