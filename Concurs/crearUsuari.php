<?php
session_start();

require_once "classeUsuaris.php";

$admin = new Usuari($_POST["Usuari"], $_POST["Contrassenya"]);
$admin->insert();
header("Location: admin.php?data=" . $_SESSION["data"]);
?>