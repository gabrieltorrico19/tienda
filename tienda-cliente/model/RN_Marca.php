<?php

require_once "data/Marca.php";
require_once "data/DB.php";

class RN_Marca extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList()
    {
        $res = $this->Execute("CALL sp_MarcaListar()");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new Marca($item["cod"], $item["nombre"], $item["descripcion"]);
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($cod)
    {
        $res = $this->Execute("CALL sp_MarcaObtener(" . intval($cod) . ")");
        $oMarca = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oMarca = new Marca($item["cod"], $item["nombre"], $item["descripcion"]);
            }
        }

        $this->ClearResults($res);
        return $oMarca;
    }

    function Save($oMarca)
    {
        $res = $this->Execute("CALL sp_MarcaInsertar('" . addslashes($oMarca->nombre) . "','" .
            addslashes($oMarca->descripcion) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Update($oMarca)
    {
        $res = $this->Execute("CALL sp_MarcaActualizar(" . intval($oMarca->cod) . ",'" .
            addslashes($oMarca->nombre) . "','" . addslashes($oMarca->descripcion) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Delete($cod)
    {
        $res = $this->Execute("CALL sp_MarcaEliminar(" . intval($cod) . ")");
        $this->ClearResults($res);
        return $res;
    }
}

?>