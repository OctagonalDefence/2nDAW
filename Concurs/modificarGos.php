<?php
session_start();

require_once "bd_utils.php";
require_once "classeGos.php";
$Goss = getGossos("nom", $_POST["nom_amagat"]);
$i = 1;

foreach ($Goss as $Gos) {
    $Gos_update = new Gos($_POST["nom"], $_POST["imatge"], $_POST["amo"], $_POST["raça"], $i);
    $Gos_update->updateGos($i . $_POST["nom_amagat"]);
    $i += 1;
    print_r($Gos_update);
    echo "<br>";
}

header("Location: admin.php?data=" . $_SESSION["data"]);
