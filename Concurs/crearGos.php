<?php
session_start();
require_once "bd_utils.php";
require_once "classeGos.php";

$insertGos = new Gos($_POST["nom"], $_POST["imatge"], $_POST["amo"], $_POST["raça"], 1);
$insertGos->insert();

header("Location: admin.php?data=" . $_SESSION["data"]);
?>
