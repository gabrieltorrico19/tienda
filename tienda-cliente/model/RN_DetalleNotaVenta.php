<?php

require_once "data/DetalleNotaVenta.php";
require_once "data/DB.php";

class RN_DetalleNotaVenta extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetListByVenta($nroNotaVenta)
    {
        $res = $this->Execute("CALL sp_DetalleNotaVentaListar(" . intval($nroNotaVenta) . ")");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new DetalleNotaVenta(
                    $item["nroNotaVenta"],
                    $item["codProducto"],
                    $item["item"],
                    $item["cant"],
                    $item["precioUnitario"],
                    $item["subtotal"]
                );
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function AgregarDetalle($nroNotaVenta, $codProducto, $cantidad, $item)
    {
        $res = $this->Execute("CALL sp_AgregarDetalleVenta(" . intval($nroNotaVenta) . "," .
            intval($codProducto) . "," . intval($cantidad) . "," . intval($item) . ")");
        $this->ClearResults($res);
        return $res;
    }
}

?>