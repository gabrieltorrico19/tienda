<?php

require_once "data/Categoria.php";
require_once "data/DB.php";

class RN_Categoria extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList()
    {
        $res = $this->Execute("CALL sp_CategoriaListar()");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new Categoria($item["cod"], $item["nombre"], $item["descripcion"] ?? "");
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($cod)
    {
        $res = $this->Execute("CALL sp_CategoriaObtener(" . intval($cod) . ")");
        $oCategoria = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oCategoria = new Categoria($item["cod"], $item["nombre"], $item["descripcion"] ?? "");
            }
        }

        $this->ClearResults($res);
        return $oCategoria;
    }

    function Save($oCategoria)
    {
        $res = $this->Execute("CALL sp_CategoriaInsertar('" . addslashes($oCategoria->nombre) . "','" .
            addslashes($oCategoria->descripcion) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Update($oCategoria)
    {
        $res = $this->Execute("CALL sp_CategoriaActualizar(" . intval($oCategoria->cod) . ",'" .
            addslashes($oCategoria->nombre) . "','" . addslashes($oCategoria->descripcion) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Delete($cod)
    {
        $res = $this->Execute("CALL sp_CategoriaEliminar(" . intval($cod) . ")");
        $this->ClearResults($res);
        return $res;
    }
}

?>