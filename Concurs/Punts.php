<?php
session_start();

require_once "classeGos.php";
require_once "bd_utils.php";

if (isset($_SESSION["puntsRonda" . $_SESSION["Ronda"]["Numero"]])) {
    $GosVell = getGossos("ID", $_SESSION["puntsRonda" . $_SESSION["Ronda"]["Numero"]]["ID"]);
    $Gos = new Gos($GosVell[0]["Nom"], $GosVell[0]["Imatge"], $GosVell[0]["Amo"], $GosVell[0]["Raca"], $GosVell[0]["Ronda"], $GosVell[0]["Punts"]);
    $Gos->treurePunt();
    $getGos = getGossos("ID", $_POST["ID"]);
    $Gos = new Gos($getGos[0]["Nom"], $getGos[0]["Imatge"], $getGos[0]["Amo"], $getGos[0]["Raca"], $getGos[0]["Ronda"], $getGos[0]["Punts"]);
    $Gos->afegirPunt();

} 

else {
    $getGos = getGossos("ID", $_POST["ID"]);
    $Gos = new Gos($getGos[0]["Nom"], $getGos[0]["Imatge"], $getGos[0]["Amo"], $getGos[0]["Raca"], $getGos[0]["Ronda"], $getGos[0]["Punts"]);
    $Gos->afegirPunt();
}

$_SESSION["puntsRonda" . $_SESSION["Ronda"]["Numero"]] = ["Nom" => $Gos->Nom, "ID" => $Gos->ID];

$_SESSION["missatge"] = "Ja has votat al gos " . $_SESSION["puntsRonda" . $_SESSION["Ronda"]["Numero"]]["Nom"] . 
".";
header("Location: index.php?data=" . $_SESSION["data"]);
