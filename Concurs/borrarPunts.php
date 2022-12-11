<?php
session_start();

require_once "bd_utils.php";
require_once "classeGos.php";


if (isset($_POST["Numero"])) {
    
    if ($_POST["Numero"] == 1) {
        update(GOS, "Punts", 0, "Ronda", $_POST["Numero"]);
    } 
    else {
        delete(GOS, "Ronda", $_POST["Numero"]);
    }

} 
else {
    updateTot(GOS, "Punts", 0, "id", 0);
    deleteTot(GOS, "Ronda", 1);
}

header("Location: admin.php?data=" . $_SESSION["data"]);
