<?php

require_once "data/Cuenta.php";
require_once "data/DB.php";

class RN_Cuenta extends DataBase
{
    function __construct()
    {
        parent::Open();
    }

    function GetList()
    {
        $res = $this->Execute("CALL sp_CuentaListar()");
        $list = array();

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $list[] = new Cuenta(
                    $item["USUARIO"] ?? "",
                    $item["PASSWORD"] ?? "",
                    $item["EMAIL"] ?? "",
                    $item["FECHACREACION"] ?? date("Y-m-d"),
                    $item["ESTADO"] ?? "activo"
                );
            }
        }

        $this->ClearResults($res);
        return $list;
    }

    function GetData($usuario)
    {
        $res = $this->Execute("CALL sp_CuentaObtener('" . addslashes($usuario) . "')");
        $oCuenta = null;

        if ($this->ContainsData($res)) {
            $data = $this->DataListStructure($res);
            foreach ($data as $item) {
                $oCuenta = new Cuenta(
                    $item["USUARIO"] ?? "",
                    $item["PASSWORD"] ?? "",
                    $item["EMAIL"] ?? "",
                    $item["FECHACREACION"] ?? date("Y-m-d"),
                    $item["ESTADO"] ?? "activo"
                );
            }
        }

        $this->ClearResults($res);
        return $oCuenta;
    }

    function Save($oCuenta)
    {
        $res = $this->Execute("CALL sp_CuentaInsertar('" . addslashes($oCuenta->usuario) . "','" .
            addslashes($oCuenta->password) . "','" . addslashes($oCuenta->email) . "','" .
            addslashes($oCuenta->estado) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Update($oCuenta)
    {
        $res = $this->Execute("CALL sp_CuentaActualizar('" . addslashes($oCuenta->usuario) . "','" .
            addslashes($oCuenta->password) . "','" . addslashes($oCuenta->email) . "','" .
            addslashes($oCuenta->estado) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Delete($usuario)
    {
        $res = $this->Execute("CALL sp_CuentaEliminar('" . addslashes($usuario) . "')");
        $this->ClearResults($res);
        return $res;
    }

    function Verificar($usuario, $password)
    {
        $res = $this->Execute("CALL sp_CuentaObtener('" . addslashes($usuario) . "')");
        $row = null;

        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $row = array_change_key_case($row, CASE_UPPER);

        if (!$row) {
            return false;
        }

        if ($row["ESTADO"] !== "activo") {
            return false;
        }

        if ($row["PASSWORD"] !== $password) {
            return false;
        }

        return $row["USUARIO"];
    }
}

?>