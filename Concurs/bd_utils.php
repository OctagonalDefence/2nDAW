<?php
require_once "classeUsuaris.php";
require_once "classeGos.php";
require_once "classeRonda.php";
const GOS = "Gos";
const RONDA = "Ronda";
const USUARIS = "Usuaris";

//Funcio per a crear gossos, rondes o usuaris, depenent de les dades que s'introdueixen

function insert(string $taula, array $dades): void {
    $pdo= connecta();

    switch ($taula) {
        case GOS:
            $sql = "insert into " . $taula . " values(?, ?, ?, ?, ?, ?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute($dades);
            break;

        case RONDA:
            $sql = "insert into " . $taula . "(Numero, DataInici, DataFi) values($dades[0], '$dades[1]', '$dades[2]')";
            $query = $pdo->prepare($sql);
            $query->execute();
            break;

        case USUARIS:
            $sql = "insert into " . $taula . " values(?, ?)";
            $query = $pdo->prepare($sql);
            $query->execute($dades);
            break;

        default:
            break;
    }

    unset($pdo);
    unset($query);
}

//Funcio per a actualitzar les dades de la columna d'una taula

function actualitzar(string $taula, string $columna, int|string $valor, string $columna_unica, string|int $valor_unic): void {

    $pdo= connecta();

    $sql = "update $taula set $columna = '$valor' where $columna_unica = '$valor_unic'";
    $query = $pdo->prepare($sql);
    $query->execute();

    unset($pdo);
    unset($query);
}

//Funcio per a actualitzar les dades d'una taula menys la columna introduida

function actualitzarTot(string $taula, string $columna, int|string $valor, string $columna_unica, string|int $valor_unic): void {

    $pdo= connecta();

    $sql = "update $taula set $columna = '$valor' where $columna_unica <> '$valor_unic'";
    $query = $pdo->prepare($sql);
    $query->execute();

    unset($pdo);
    unset($query);
}

//Funcio per a borrar les dades de la columna d'una taula

function borrar(string $taula, string $columna_unica, int|string $valor_unic): void {

    $pdo= connecta();

    $sql = "delete from $taula where $columna_unica = $valor_unic";
    $query = $pdo->prepare($sql);
    $query->execute();

    unset($pdo);
    unset($query);
}

//Funcio per a borrar les dades d'una taula menys la columna introduida

function borrarTot(string $taula, string $columna_unica, int|string $valor_unic): void
{
    $pdo= connecta();

    $sql = "delete from $taula where $columna_unica <> $valor_unic";
    $query = $pdo->prepare($sql);
    $query->execute();

    unset($pdo);
    unset($query);
}

//Funcio per a seleccionar un usuari, introduint-li l'usuari i la contrassenya

function getUsuari(string $usuari, string $Contrassenya): Usuaris|null {
    $pdo= connecta();

    $query = $pdo->prepare("select * from Usuaris where Usuari = ? AND Contrassenya = ?");
    $query->execute(array($usuari, md5($Contrassenya)));
    
    $Usuaris = null;
    foreach ($query as $row) {
        $Usuaris = new Usuaris($row["Usuari"], $row["Contrassenya"]);
    }

    unset($pdo);
    unset($query);

    return $Usuaris;
}

//Funcio per a obtenir una ronda, introduint-li el numero

function getRonda(int $Numero): array|null {

    $pdo= connecta();

    $query = $pdo->prepare("select * from Rondes where Numero = ?");
    $query->execute(array($Numero));

    $Ronda = [];

    foreach ($query as $row) {
        $Ronda = ["Numero" => $row["Numero"], "DataInici" => $row["DataInici"], "DataFi" => $row["DataFi"]];
    }

    unset($pdo);
    unset($query);

    return $Ronda;
}

//Funcio que ens retorna totes les rondes registrades

function getRondes(): array|null {

    $pdo= connecta();

    $query = $pdo->prepare("select * from Rondes");
    $query->execute();

    $Ronda = [];
    $i = 0;

    foreach ($query as $row) {
        $Ronda[$i] = ["Numero" => $row["Numero"], "DataInici" => $row["DataInici"], "DataFi" => $row["DataFi"]];
        $i += 1;
    }

    unset($pdo);
    unset($query);

    return $Ronda;
}

//Funcio que ens retorna tots els gossos registrats

function getAllGossos(): array|null
{
    $pdo= connecta();

    $query = $pdo->prepare("select * from Gossos");
    $query->execute();

    $Gossos = [];
    $i = 0;

    foreach ($query as $row) {
        $Gossos[$i] = ["Nom" => $row["Nom"], "Imatge" => $row["Imatge"], "Amo" => $row["Amo"], "Raca" => $row["Raca"], "Ronda" => $row["Ronda"], "Punts" => $row["Punts"]];
        $i += 1;
    }

    unset($pdo);
    unset($query);

    return $Gossos;
}


//Funcio que ens retorna les dades d'un gos introduint-li la id

function getGossos(string $columna, string|int $ID): array|null {
    $pdo= connecta();

    $query = $pdo->prepare("select * from Gossos where $columna = ?");
    $query->execute([$ID]);

    $Gos = [];
    $i = 0;

    foreach ($query as $row) {
        $Gos[$i] = ["ID" => $row["ID"], "Nom" => $row["Nom"], "Imatge" => $row["Imatge"], "Amo" => $row["Amo"], "Raca" => $row["Raca"], "Ronda" => $row["Ronda"], "Punts" => $row["Punts"]];
        $i += 1;
    }

    unset($pdo);
    unset($query);

    return $Gos;
}

//Funcio que ens retorna una ronda en introduir-li una data que esta entre la dataInici i la dataFi

function getRondaD(string $data): array|null {

    $pdo= connecta();

    $query = $pdo->prepare("select * from Rondes where DataInici <= ? AND DataFi >= ?");
    $query->execute([$data, $data]);

    $Ronda = [];

    foreach ($query as $row) {
        $Ronda = ["Numero" => $row["Numero"], "DataInici" => $row["DataInici"], "DataFi" => $row["DataFi"]];
    }

    unset($pdo);
    unset($query);

    return $Ronda;
}

//Funcio que crea els gossos en la ronda introduida

function crearGossos(array $Gossos, int $Ronda): void {

    $pdo= connecta();

    foreach ($Gossos as $Gos_registre) {
        $Gos = new Gos($Gos_registre["Nom"], $Gos_registre["Imatge"], $Gos_registre["Amo"], $Gos_registre["Raca"], $Ronda);
        $query = $pdo->prepare("insert into Gossos values(?, ?, ?, ?, ?, ?, ?)");
        $query->execute([$Gos->ID, $Gos->Nom, $Gos->Imatge, $Gos->Amo, $Gos->Raca, $Gos->Ronda, 0]);
    }

    unset($pdo);
    unset($query);
}

//Funcio que ordena els gossos en la ronda introduida

function sortGossos(int $Ronda): array|null {

    $pdo= connecta();

    $query = $pdo->prepare("select * from Gossos where Ronda = ? order by Punts ASC");
    $query->execute([$Ronda]);

    $newGossos = [];

    foreach ($query as $row) {
        array_push($newGossos, [
            "ID" => $row["ID"], "Nom" => $row["Nom"], "Imatge" => $row["Imatge"],
            "Amo" => $row["Amo"], "Raca" => $row["Raca"], "Ronda" => $row["Ronda"], "Punts" => $row["Punts"]
        ]);
    }

    $concursants = [];
    if ($newGossos != null) {
        $puntsMinims = $newGossos[0]["Punts"];
        $length = count($newGossos);
        for ($i = 0; $i < $length; $i++) {
            if ($newGossos[$i]["Punts"] == $puntsMinims) {
                array_push($concursants, $newGossos[$i]);
                unset($newGossos[$i]);
            }
        }
    }

    return checkGossos($Ronda, $newGossos, $concursants);
}

//Funcio que fa els calculs per a eliminar el gos en cada ronda

function calculElmininacio(int $Ronda, array $newGossos, array $concursants) {

    $pdo= connecta();

    $query = $pdo->prepare("select * from Gossos where Ronda = ? order by Punts ASC");
    $query->execute([$Ronda]);

    $concursantsPendents = [];

    //En cas d'empat, posarem els gossos empatats dins de l'array "concursantsPendents"

    foreach ($query as $row) {

        for ($j = 0; $j < count($concursants); $j++) {

            if ($row["Nom"] == $concursants[$j]["Nom"]) {

                array_push($concursantsPendents, [
                    "ID" => $row["ID"], "Nom" => $row["Nom"], "Imatge" => $row["Imatge"],
                    "Amo" => $row["Amo"], "Raca" => $row["Raca"], "Ronda" => $row["Ronda"], "Punts" => $row["Punts"]
                ]);
            }
        }
    }

    $checkGossos = [];

    //Els gossos que tenen menys punts s'introdueixen a l'array checkGossos

    if ($concursantsPendents != null) {
        $puntsMinims = $concursantsPendents[0]["Punts"];
        $length = count($concursantsPendents);

        for ($i = 0; $i < $length; $i++) {
            if ($concursantsPendents[$i]["Punts"] == $puntsMinims) {
                array_push($checkGossos, $concursantsPendents[$i]);
                unset($concursantsPendents[$i]);
            }
        }

        //Els gossos que no arriben al minim de punts s'introdueixen a l'array newGosso s

        foreach ($concursantsPendents as $Gos) {
            array_push($newGossos, $Gos);
        }
    }

    return checkGossos($Ronda, $newGossos, $checkGossos);
}

//Funcio que comprova els gossos que tenen menys punts, en cas d'empat o es mirara la ronda anterior o es triara aleatoriament
function checkGossos(int $Ronda, array $newGossos, array $checkGossos) {

   //Si nomes n'hi ha un, s'eliminarà
    if (count($checkGossos) == 1) {

        return $newGossos;
        
    } 

    //en cas de que hi hagi empat, es comprovara la ronda anterior o es triara aleatoriament, depenent del numero de la ronda
    else {

        //si es la ronda numero 1, es triara aleatoriament
        if ($Ronda == 1) {
            unset($checkGossos[rand(0, count($checkGossos) - 1)]);
            foreach ($checkGossos as $Gos) {
                array_push($newGossos, $Gos);
            }
            return $newGossos;
        } 

        //en cas de que no sigui la ronda 1, es comprovara la ronda anterior i es triara el que tenia menys punts
        else {
            return calculElmininacio($Ronda - 1, $newGossos, $checkGossos);
        }
    }
}


//Funcio per a connectar a la base de dades
function connecta() {

    try {
    $hostname = "localhost";
    $dbname = "gossos";
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
