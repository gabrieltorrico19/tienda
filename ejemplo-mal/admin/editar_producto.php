<?php

if (isset($_GET["id"])) {
    header("Location: ../control/c-admin-product-edit.php?id=" . urlencode($_GET["id"]));
    exit();
}

header("Location: ../control/c-admin-products.php");
exit();