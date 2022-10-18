<?php
//aquest codi comprova que les funcions que has escrit estiguin en la llista
session_start();

if (in_array($_POST['Funcions'], $_SESSION['llistatFuncions'])) {

    $_SESSION['correctes'][] = $_POST['Funcions'];
    unset($_SESSION['llistatFuncions'][array_search($_POST['Funcions'], $_SESSION['llistatFuncions'])]);
    header('Location: WordGuess.php', true, 302);
    
} 

else if (in_array($_POST['Funcions'], $_SESSION['correctes'])) {

    header('Location: WordGuess.php?error=Repetida', true, 303);
} 

else {

    header('Location: WordGuess.php?error=Incorrecte', true, 303);
}
?>

