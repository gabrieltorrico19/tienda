<?php

require_once "data/Cliente.php";
require_once "data/DB.php";

class RN_Cliente extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList()
    {
        $res = $this->Execute("CALL sp_ClienteListar()");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new Cliente(
                    $item["CI"] ?? "",
                    $item["NOMBRES"] ?? "",
                    $item["APPATERNO"] ?? "",
                    $item["APMATERNO"] ?? "",
                    $item["CORREO"] ?? "",
                    $item["DIRECCION"] ?? "",
                    $item["NROCELULAR"] ?? "",
                    $item["USUARIOCUENTA"] ?? "",
                    $item["FECHAREGISTRO"] ?? date("Y-m-d"),
                    $item["ESTADO"] ?? "activo"
                );
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($ci)
    {
        $res = $this->Execute("CALL sp_ClienteObtener('" . addslashes($ci) . "')");
        $oCliente = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oCliente = new Cliente(
                    $item["CI"] ?? "",
                    $item["NOMBRES"] ?? "",
                    $item["APPATERNO"] ?? "",
                    $item["APMATERNO"] ?? "",
                    $item["CORREO"] ?? "",
                    $item["DIRECCION"] ?? "",
                    $item["NROCELULAR"] ?? "",
                    $item["USUARIOCUENTA"] ?? "",
                    $item["FECHAREGISTRO"] ?? date("Y-m-d"),
                    $item["ESTADO"] ?? "activo"
                );
            }
        }

        $this->ClearResults($res);
        return $oCliente;
    }

    function Save($oCliente)
    {
        $res = $this->Execute("CALL sp_ClienteInsertar('" . addslashes($oCliente->ci) . "','" .
            addslashes($oCliente->nombres) . "','" . addslashes($oCliente->apPaterno) . "','" .
            addslashes($oCliente->apMaterno) . "','" . addslashes($oCliente->correo) . "','" .
            addslashes($oCliente->direccion) . "','" . addslashes($oCliente->nroCelular) . "','" .
            addslashes($oCliente->usuarioCuenta) . "','" . addslashes($oCliente->estado) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Update($oCliente)
    {
        $res = $this->Execute("CALL sp_ClienteActualizar('" . addslashes($oCliente->ci) . "','" .
            addslashes($oCliente->nombres) . "','" . addslashes($oCliente->apPaterno) . "','" .
            addslashes($oCliente->apMaterno) . "','" . addslashes($oCliente->correo) . "','" .
            addslashes($oCliente->direccion) . "','" . addslashes($oCliente->nroCelular) . "','" .
            addslashes($oCliente->estado) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Delete($ci)
    {
        $res = $this->Execute("CALL sp_ClienteEliminar('" . addslashes($ci) . "')");
        $this->ClearResults($res);
        return $res;
    }
}

?>