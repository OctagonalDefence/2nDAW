<?php 
session_start();


if ($_POST['method'] == "signup") {

    //começem declarant la variable llistaConnexions, que es la llista de les connexions realitzades i tambe fem que llegeixi el fitxer connexions.json ja que aquest es el que conte la llista
    $llistaConnexions = array();
    $llistaConnexions = llegirDades("connexions.json");


        //en registrar un usuari, primer llegim les dades introduides en el formulari de registre i les anotem en el fitxer users.json
        $dadesIntroduides= array();
        $dadesIntroduides["Nom"] = $_POST["Nom"];
        $dadesIntroduides["Correu"] = $_POST["Correu"];
        $dadesIntroduides["Contrassenya"] = $_POST["Contrassenya"];
        $llistaUsuaris = llegirDades("users.json");
        $existeix = false;

        //en cas de que el correu ja estigui registrat, donara un error dient que l'usuari ja existeix, tambe ho anotara en la llista de connexions aclarant que l'usuari ja existia
        if(array_key_exists($_POST["Correu"], $llistaUsuaris)) {

            $llistaConnexions[] = ["ip"=> $_SERVER['REMOTE_ADDR'], "user" => $_POST["Correu"], "time" => date('Y-m-d H:i:s'), "status" => "usuari-existeix"];
            escriureDades($llistaConnexions, "connexions.json");
            header("Location:index.php?error=usuari-existeix", true, 303);
        } 
        
        //si no es dona l'error, l'usuari sera creat i anotat en el registre d'usuaris, tambe ho anotara en la llista de conexions aclarant que l'usuari ha sigut creat
        else {

            $llistaUsuaris[$_POST["Correu"]] = $dadesIntroduides;
            escriureDades($llistaUsuaris,"users.json");
            $_SESSION["Nom"] = $llistaUsuaris[$_POST["Correu"]]["Nom"];            
            $_SESSION["Correu"] = $_POST["Correu"];
            $llistaConnexions[] = ["ip"=> $_SERVER['REMOTE_ADDR'], "user" => $_POST["Correu"], "time" => date('Y-m-d H:i:s'), "status" => "usuari-creat"];
            escriureDades($llistaConnexions, "connexions.json");
            //ens redirigira a hola.php perque registrarse ja conta com un singup
            header("Location:hola.php" , true, 302);
        }

    } 
    else if ($_POST['method'] == "signin") {
       //primer llegirem les dades introduides en el formulari de singin
       $dadesIntroduides = array();
       $dadesIntroduides = $_POST["Correu"];
       $dadesIntroduides = $_POST["Contrassenya"];
       $llistaUsuaris = llegirDades("users.json");

       //comprovem si el correu esta en la llista d'usuaris, si es dona que si, procedirà
       if(array_key_exists($_POST["Correu"], $llistaUsuaris)) {

           //seguidament comprovarem que la contrassenya sigui correcte, si ho es, fara el singup i ens redigira al hola.php, tambe registrara en el connexions.json  que un usuari ha fet el singin 
           if($llistaUsuaris[$_POST["Correu"]]["Contrassenya"] ==  $_POST["Contrassenya"]){

           $_SESSION["Nom"] = $llistaUsuaris[$_POST["Correu"]]["Nom"];
           $_SESSION["Correu"] = $_POST["Correu"];           
           $llistaConnexions[] = ["ip"=> $_SERVER['REMOTE_ADDR'], "user" => $_POST["Correu"], "time" => date('Y-m-d H:i:s'), "status" => "usuari-creat"];
           escriureDades($llistaConnexions, "connexions.json");
           //ens redirigira a hola.php 
           header("Location:hola.php" , true, 302);
           }
           
           //en cas de que la contrassenya sigui incorrecte, ho anotara al connexions.json i ens redigira de tornada a la pagina principal amb l'error de contrassenya incorrecte
           else {

               $llistaConnexions[] = ["ip"=> $_SERVER['REMOTE_ADDR'], "user" => $_POST["Correu"], "time" => date('Y-m-d H:i:s'), "status" => "contrasenya-incorrecte"];
               escriureDades($llistaConnexions, "connexions.json");
               //ens redirigeix a la pagina principal amb l'error de contrassenya incorrecte
               header("Location:index.php?error=contrasenya-incorrecte", true, 303);
           }

       }
    } 
       
       //en cas de que el correu sigui incorrecte, ho anotara al connexions.json i ens redirigira a la pagina principal amb l'error de correu incorrecte
       else {
           $llistaConnexions[] = ["ip"=> $_SERVER['REMOTE_ADDR'], "user" => $_POST["Correu"], "time" => date('Y-m-d H:i:s'), "status" => "correu-incorrecte"];
           escriureDades($llistaConnexions, "connexions.json");
           //ens redirigeix a la pagina principal amb l'error de correu incorrecte
           header("Location:index.php?error=correu-incorrecte", true, 303);
       } 


       //aquesta funcio es per quan ja s'ha entrat a hola.php i s'ha polsat el botor de tencar sessio
if(isset($_POST["tancaSessio"])) {
    
    //tanca la sessio i ens redirigeix a la pagina principal
    session_destroy();
    header("Location: index.php", true, 302);
}


   //aquesta funcio serveix per a llegir les dades de users.json
function llegirDades(string $file) : array {
   $var = [];
   if ( file_exists($file) ) {
       $var = json_decode(file_get_contents($file), true);
   }

   return $var;
}



//funcio per escrirue dades en cualsevol dels dos fitxers
function escriureDades(array $dades, string $file): void {

   file_put_contents($file,json_encode($dades, JSON_PRETTY_PRINT));
}




?>