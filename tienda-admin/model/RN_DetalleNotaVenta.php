<?php

require_once "data/DetalleNotaVenta.php";
require_once "data/DB.php";

class RN_DetalleNotaVenta extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList($nroNotaVenta)
    {
        $res = $this->Execute("CALL sp_DetalleNotaVentaListar(" . intval($nroNotaVenta) . ")");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new DetalleNotaVenta(
                    $item["NRO"] ?? 0,
                    $item["CODPRODUCTO"] ?? 0,
                    $item["ITEM"] ?? 0,
                    $item["CANT"] ?? 0,
                    $item["PRECIOUNITARIO"] ?? 0,
                    $item["SUBTOTAL"] ?? 0
                );
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function Save($nroNotaVenta, $codProducto, $cantidad, $item)
    {
        $res = $this->Execute("CALL sp_AgregarDetalleVenta(" . intval($nroNotaVenta) . "," .
            intval($codProducto) . "," . intval($cantidad) . "," . intval($item) . ")");
        $this->ClearResults($res);
        return $res;
    }
}

?>