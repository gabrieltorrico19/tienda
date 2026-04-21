<?php

require_once "data/Industria.php";
require_once "data/DB.php";

class RN_Industria extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList()
    {
        $res = $this->Execute("CALL sp_IndustriaListar()");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new Industria($item["cod"], $item["nombre"]);
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($cod)
    {
        $res = $this->Execute("CALL sp_IndustriaObtener(" . intval($cod) . ")");
        $oIndustria = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oIndustria = new Industria($item["cod"], $item["nombre"]);
            }
        }

        $this->ClearResults($res);
        return $oIndustria;
    }

    function Save($oIndustria)
    {
        $res = $this->Execute("CALL sp_IndustriaInsertar('" . addslashes($oIndustria->nombre) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Update($oIndustria)
    {
        $res = $this->Execute("CALL sp_IndustriaActualizar(" . intval($oIndustria->cod) . ",'" .
            addslashes($oIndustria->nombre) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Delete($cod)
    {
        $res = $this->Execute("CALL sp_IndustriaEliminar(" . intval($cod) . ")");
        $this->ClearResults($res);
        return $res;
    }
}

?>