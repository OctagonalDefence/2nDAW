<?php

const TAULA_USERS = 'users';
const TAULA_CONNX = 'connexions';
const SELECT_USER = "select usuari, email, contrassenya from users";
const SELECT_CONNX = "select ip, user, time, status from connexions";

//funcio per a llegir dades de qualsevol de les dues taules
function llegirTaula(string $select): array {

    $pdo= connecta();
    $query = $pdo->prepare($select);
    $query->execute();
    $var = [];
    //llegim la taula users
    if ($select == SELECT_USER) {

        foreach ($query as $row) {

            $var[$row["email"]] = [ "usuari" => $row["usuari"],"email" => $row["email"], "contrassenya" => $row["contrassenya"]];
        }
    } 
    //llegim la taula connexions
    else {

        foreach ($query as $row) {

            $var[]= ["ip"=> $row["ip"], "user" => $row["user"], "time"=> $row["time"], "status"=>$row["status"]];
        }
    }
    
    //borrem les dades de pdo i queri per a raons d'eficiencia
    unset($pdo);
    unset($query);

    return $var;
}

//funcio per a escriure a les taules, rebem les dades i quina taula es
function escriureTaula(array $dades, string $taula): void {

    //passem les dades del login a la funcio escriure
    if ($taula == "users") {

        escriure(" values (?, ?, md5(?))", $taula, $dades);
    } 
    
    //passem les dades de la connexio a la funcio escriure
    else {

        escriure(" values (?, ?, ?, ?)", $taula, $dades);
    }
}

//aquesta funcio ja venia feta, nomes cambiem el metode de rebre les conexions
function print_conns(string $email): string {

    $output = "";
    //metode per a rebre les connexions
    $data = llegirTaula(SELECT_CONNX);
    foreach ($data as $vals) {

        if ($vals["user"] == $email && str_contains($vals["status"], "success")){

            $output .= "Connexió des de " . $vals["ip"] . " amb data " . $vals["time"] . "<br>\n";
        }
            
    }

    return $output;
}


//funcio per a escriure en qualsevol de les dues taules, depenent de les dades rebudes
function escriure (string $columnes, string $taula, array $dades, string $user_email = "") {

    $pdo= connecta();
    $sql = "insert into " . $taula . $columnes;
    $query = $pdo->prepare($sql);
    //escriptura en la taula users
    if ($taula == "users") {

        $query->execute(array($dades["usuari"], $dades["email"], $dades["contrassenya"]));
    }
    //escriptura en la taula connexions
    else {
        $query->execute($dades);
    }

    //deteccio d'errors
    $e = $query->errorInfo();
    if ($e[0] != '00000') {

        echo "\nPDO::errorInfo():\n";
        die("Error en accedir a la base de dades: " . $e[2]);
    }
}

//funcio per a conectar-se a la base de dades
function connecta() {

    try {
    $hostname = "localhost";
    $dbname = "dwes_ericromero_autpdo";
    $username = "dwes_user";
    $pw = "dwes_pass";
    $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
    return $pdo;
  } 
  
  catch (PDOException $e) {

    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
  }


}