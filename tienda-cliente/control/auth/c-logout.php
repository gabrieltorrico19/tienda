<?php

session_start();
unset($_SESSION['CLIENTE_USER'], $_SESSION['CLIENTE_CI']);
header("Location: ../../index.php");
exit();

?>