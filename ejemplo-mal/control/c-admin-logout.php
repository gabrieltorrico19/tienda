<?php

session_start();
session_destroy();
header("Location: c-admin-login.php");
exit();
