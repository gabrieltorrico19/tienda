<?php

require_once "data/Producto.php";
require_once "data/DB.php";

class RN_Producto extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList()
    {
        $res = $this->Execute("CALL sp_ProductoListar()");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new Producto(
                    $item["cod"],
                    $item["nombre"],
                    $item["descripcion"],
                    $item["precio"],
                    $item["imagen"],
                    $item["estado"],
                    $item["codMarca"],
                    $item["codIndustria"],
                    $item["codCategoria"],
                    $item["marca"],
                    $item["industria"],
                    $item["categoria"]
                );
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($cod)
    {
        $res = $this->Execute("CALL sp_ProductoObtener(" . intval($cod) . ")");
        $oProducto = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oProducto = new Producto(
                    $item["cod"],
                    $item["nombre"],
                    $item["descripcion"],
                    $item["precio"],
                    $item["imagen"],
                    $item["estado"],
                    $item["codMarca"],
                    $item["codIndustria"],
                    $item["codCategoria"],
                    $item["marca"],
                    $item["industria"],
                    $item["categoria"]
                );
            }
        }

        $this->ClearResults($res);
        return $oProducto;
    }
}

?>