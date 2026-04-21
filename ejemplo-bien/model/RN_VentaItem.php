<?php

require_once "data/VentaItem.php";
require_once "data/DB.php";

class RN_VentaItem extends DataBase{

	function __construct()
	{
		parent::Open();
	}

	function GetList(){
		$sql = "Select * from venta_item where estado = 'Activo'";
		$res = $this->Execute($sql);
		
		$list = array();

		if ($this->ContainsData($res)){
			$data = $this->DataListStructure($res);
			foreach ($data as $item) {
				$list[] = new VentaItem(
					$item["idVenta"],
					$item["idTipoPizza"],
					$item["idTamanho"],
					$item["hashVentaItem"],
					$item["cantidad"],
					$item["precioUnitario"],
					$item["subtotal"],
					$item["estado"]
				);
			}
		}

		return $list;
	}

	function GetListByIdVenta($idVenta){
		$sql = "Select * from venta_item where estado = 'Activo' and idVenta = " . $idVenta;
		$res = $this->Execute($sql);
		
		$list = array();

		if ($this->ContainsData($res)){
			$data = $this->DataListStructure($res);
			foreach ($data as $item) {
				$list[] = new VentaItem(
					$item["idVenta"],
					$item["idTipoPizza"],
					$item["idTamanho"],
					$item["hashVentaItem"],
					$item["cantidad"],
					$item["precioUnitario"],
					$item["subtotal"],
					$item["estado"]
				);
			}
		}

		return $list;
	}

	function Save($oVentaItem){
		$sql = "Insert into venta_item values (
		" . $oVentaItem->idVenta . ",
		" . $oVentaItem->idTipoPizza . ",
		" . $oVentaItem->idTamanho . ",
		'" . $oVentaItem->hashVentaItem . "',
		" . $oVentaItem->cantidad . ",
		'" . $oVentaItem->precioUnitario . "',
		'" . $oVentaItem->subtotal . "',
		'" . $oVentaItem->estado . "')";

		return $this->Execute($sql);
	}

	function Delete($hashVentaItem){
		$sql = "Update venta_item set estado = 'Inactivo' where hashVentaItem = '" . $hashVentaItem . "'";
		return $this->Execute($sql);
	}

	function DeleteByIdVenta($idVenta){
		$sql = "Update venta_item set estado = 'Inactivo' where idVenta = " . $idVenta;
		return $this->Execute($sql);
	}
}

?>
