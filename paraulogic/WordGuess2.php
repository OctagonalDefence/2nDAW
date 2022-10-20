<?php
//aquest codi comprova que les funcions que has escrit estiguin en la llista
session_start();

if (in_array($_POST['llistatFuncions'], $_SESSION['Funcions'])) {

    $_SESSION['correctes'][] = $_POST['llistatFuncions'];
    unset($_SESSION['Funcions'][array_search($_POST['llistatFuncions'], $_SESSION['Funcions'])]);
    header('Location: WordGuess.php', true, 302);
    
} 

else if (in_array($_POST['Funcions'], $_SESSION['correctes'])) {

    header('Location: WordGuess.php?error=Repetida', true, 303);
} 

else {

    header('Location: WordGuess.php?error=Incorrecte', true, 303);
}
?>

