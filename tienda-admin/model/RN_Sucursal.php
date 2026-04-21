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
                    $item["cod"],
                    $item["nombre"],
                    $item["direccion"],
                    $item["nroTelefono"],
                    $item["estado"],
                    $item["fechaCreacion"]
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
                    $item["cod"],
                    $item["nombre"],
                    $item["direccion"],
                    $item["nroTelefono"],
                    $item["estado"],
                    $item["fechaCreacion"]
                );
            }
        }

        $this->ClearResults($res);
        return $oSucursal;
    }

    function Save($oSucursal)
    {
        $sql = "CALL sp_SucursalInsertar('" . addslashes($oSucursal->nombre) . "','" .
            addslashes($oSucursal->direccion) . "','" . addslashes($oSucursal->nroTelefono) . "','" .
            addslashes($oSucursal->estado) . "')";

        $res = $this->Execute($sql);
        $this->ClearResults($res);
        return $res;
    }

    function Update($oSucursal)
    {
        $sql = "CALL sp_SucursalActualizar(" . intval($oSucursal->cod) . ",'" .
            addslashes($oSucursal->nombre) . "','" . addslashes($oSucursal->direccion) . "','" .
            addslashes($oSucursal->nroTelefono) . "','" . addslashes($oSucursal->estado) . "')";

        $res = $this->Execute($sql);
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