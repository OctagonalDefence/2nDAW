<?php
//fa un timeout en 1 min
$timeout = 60;

ini_set( "session.gc_maxlifetime", $timeout );
ini_set( "session.cookie_lifetime", $timeout );


session_start();

//agafa les dades del form del login
 $Correu = $_POST['Correu'];
 $Contrasenya = $_POST['Contrasenya'];
 $file ="users.json";


 //llegeix aquestes dades en aquesta funcio
 function llegeix(string $file) : array {
    $var = [];
    if ( file_exists($file) ) {
        $var = json_decode(file_get_contents($file), true);
    }
    return $var;
}


//aqui compara que la contrasenya i el correu del log in estiguin dins el users.json
 $data = llegeix($file);
 foreach ($data as $var) {
     if($var['Correu'] == $Correu 
        && $var['Contrasenya'] == $Contrasenya) {
            session_name($var['Nom']);
            session_start();
         $_SESSION[$var['Nom']];
         //si tot es correcte, ens envia al hola.php
         header('Location: hola.php');         
     }

     
 }

 