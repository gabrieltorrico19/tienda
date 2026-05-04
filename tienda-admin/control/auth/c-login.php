<?php

require_once "../config.php";

session_start();
$error = null;
if (isset($_SESSION['LOGIN_ERROR'])) {
	$error = $_SESSION['LOGIN_ERROR'];
	unset($_SESSION['LOGIN_ERROR']);
}

include_once "../../view/auth/v-login.php";

?>