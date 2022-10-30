<?php
session_start();


if (!isset($_SESSION["data"])){

    $_SESSION["data"] = time();
} 

else if (time() - $_SESSION["data"] >= 60) {

    header("Location:index.php", true, 303);
}

//en cas de que passin mes de 60 segons
$llistaUsuaris = "users.json";
$usuaris = json_decode(file_get_contents($llistaUsuaris), true);
//llegim les dades de users.json
$llistaConnexions = "connexions.json";
$connexions = json_decode(file_get_contents($llistaConnexions), true);
//llegim les dades de connexions.json
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Benvingut</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">

</head>
<body>
<div class="container noheight" id="container">
    <div class="welcome-container">
        <h1>Benvingut!</h1>
        <div>Hola <?php 

        if(isset($_SESSION["Nom"])){
            echo $_SESSION["Nom"];
        }
       
        ?>, les teves darreres connexions són:</div><br>
        <div> <?php
         //llegeix conexions.json i busca les vegades que l'usuari actual ha entrat en la sessio i en mostra la ip i la data
            foreach ($connexions as $conexio) {
                if ($conexio['user'] == $_SESSION['Correu']) {

                    echo "Es va connectar desde " . $conexio['ip'] . " el dia " . $conexio['time'] . "<br>";
                }
            }
            ?></div>
        <form action="process.php" method="post">
        <!--Boto per a tencar la sessio, crida a una funcio del process.php-->
            <button name="tancaSessio">Tanca la sessió</button>
        </form>
    </div>
</div>
</body>
</html>
