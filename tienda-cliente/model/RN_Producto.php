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
                    $item["COD"] ?? 0,
                    $item["NOMBRE"] ?? "",
                    $item["DESCRIPCION"] ?? "",
                    $item["PRECIO"] ?? 0,
                    $item["IMAGEN"] ?? "",
                    $item["ESTADO"] ?? "disponible"
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
                    $item["COD"] ?? 0,
                    $item["NOMBRE"] ?? "",
                    $item["DESCRIPCION"] ?? "",
                    $item["PRECIO"] ?? 0,
                    $item["IMAGEN"] ?? "",
                    $item["ESTADO"] ?? "disponible"
                );
            }
        }

        $this->ClearResults($res);
        return $oProducto;
    }
}

?>