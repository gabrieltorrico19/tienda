<?php

require_once __DIR__ . "/data/Producto.php";
require_once __DIR__ . "/data/DB.php";

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

    function Save($oProducto)
    {
        $nombre = addslashes($oProducto->nombre);
        $descripcion = addslashes($oProducto->descripcion);
        $imagen = addslashes($oProducto->imagen);
        $estado = addslashes($oProducto->estado);

        $sql = "CALL sp_ProductoInsertar(" .
            "'" . $nombre . "'," .
            "'" . $descripcion . "'," .
            floatval($oProducto->precio) . "," .
            "'" . $imagen . "'," .
            "'" . $estado . "'," .
            intval($oProducto->codMarca) . "," .
            intval($oProducto->codIndustria) . "," .
            intval($oProducto->codCategoria) . "," .
            "@p_cod)";

        $res = $this->Execute($sql);
        $this->ClearResults($res);
        return $res;
    }

    function Update($oProducto)
    {
        $nombre = addslashes($oProducto->nombre);
        $descripcion = addslashes($oProducto->descripcion);
        $imagen = addslashes($oProducto->imagen);
        $estado = addslashes($oProducto->estado);

        $sql = "CALL sp_ProductoActualizar(" .
            intval($oProducto->cod) . "," .
            "'" . $nombre . "'," .
            "'" . $descripcion . "'," .
            floatval($oProducto->precio) . "," .
            "'" . $imagen . "'," .
            "'" . $estado . "'," .
            intval($oProducto->codMarca) . "," .
            intval($oProducto->codIndustria) . "," .
            intval($oProducto->codCategoria) . ")";

        $res = $this->Execute($sql);
        $this->ClearResults($res);
        return $res;
    }

    function Delete($cod)
    {
        $res = $this->Execute("CALL sp_ProductoEliminar(" . intval($cod) . ")");
        $this->ClearResults($res);
        return $res;
    }

    function ListMarcas()
    {
        $res = $this->Execute("CALL sp_MarcaListar()");
        $data = array();
        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
        }
        $this->ClearResults($res);
        return $data;
    }

    function ListIndustrias()
    {
        $res = $this->Execute("CALL sp_IndustriaListar()");
        $data = array();
        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
        }
        $this->ClearResults($res);
        return $data;
    }

    function ListCategorias()
    {
        $res = $this->Execute("CALL sp_CategoriaListar()");
        $data = array();
        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
        }
        $this->ClearResults($res);
        return $data;
    }
}

?>