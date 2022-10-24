<?php


//comprova que s'hagin enviat correctament les dades del form, si hi ha error, el mostrara
if(empty($_POST["Nom"])) {
     $error = "<label class='text-danger'>Enter Name</label>";
}

else if(empty($_POST["Correu"])) {
     $error = "<label class='text-danger'>Enter Gender</label>";
}

else if(empty($_POST["Contrasenya"])) {
     $error = "<label class='text-danger'>Enter education</label>";
}  

var_dump ($_POST);

//si existeix users.json, escriura les dades en aquest fitxer
    if(file_exists('users.json')) {

         $final_data=fileWriteAppend();
         if(file_put_contents('users.json', $final_data)) {
              $message = "<label class='text-success'>Data added Success fully</p>";
         }
    }
    //si no existeix, creara el fitxer
    else {
         $final_data=fileCreateWrite();
         if(file_put_contents('users.json', $final_data)) {
              $message = "<label class='text-success'>File createed and  data added Success fully</p>";
         }
    
    }
    

    //aquesta funcio escriu les dades dins l'array que ja existeix en el json
    function fileWriteAppend(){
            $current_data = file_get_contents('users.json');
            $array_data = json_decode($current_data, true);
            $extra = array(
                 'Nom'               =>     $_POST['Nom'],
                 'Correu'          =>     $_POST["Correu"],
                 'Contrasenya'          =>     $_POST["Contrasenya"],
            );
            $array_data[] = $extra;
            $final_data = json_encode($array_data);
            return $final_data;
    }

    //aquesta funcio serveix per que, en cas de que no hi hagi el fitxer, creara aquest i l'array necessari dins d'aquest
    function fileCreateWrite(){
            $file=fopen("users.json","w");
            $array_data=array();
            $extra = array(
                 'Nom'               =>     $_POST['Nom'],
                 'Correu'          =>     $_POST["Correu"],
                 'Contrasenya'          =>     $_POST["Contrasenya"],
            );
    
            $array_data[] = $extra;
            $final_data = json_encode($array_data);
            fclose($file);
            return $final_data;
    }
    //al haver creat l'usuari, tornem a index.php per a fer el login
    header('Location: index.php');
?>
