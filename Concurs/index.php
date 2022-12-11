<?php
session_start();
require_once "bd_utils.php";

//S'agafa la data dek GET o la data de la sessio
if (isset($_GET["data"])) {
    $_SESSION["data"] = date("Y-m-d", strtotime($_GET["data"]));
} else {
    $_SESSION["data"] = date("Y-m-d");
}

//En cas d'entrar abans de la data, nomes es visualitzara el login de l'admin
if ($_SESSION["data"] < getRonda(1)["DataInici"]) {
?>
    <h2>Accés administradors</h2>
    <form action="process_login_admin.php" method="POST">
        <input type="text" name="Usuari" placeholder="Usuari">
        <input type="password" name="Contrassenya" placeholder="Contrassenya">
        <input type="submit" value="Entra">
    </form>
<?php

} 

//En cas d'entrar despres de la data, nomes es visualitzaran els resultats
elseif ($_SESSION["data"] > getRonda(8)["DataFi"]) {
    header("Location: resultats.php");
} 

else {
    $Ronda_actual = getRondaD($_SESSION["data"]);
    $_SESSION["Ronda"] = ["Numero" => $Ronda_actual["Numero"], "DataInici" => $Ronda_actual["DataInici"], "DataFi" => $Ronda_actual["DataFi"]];

    
    if (getGossos("Ronda", $_SESSION["Ronda"]["Numero"]) == null) {
        crearGossos(sortGossos($_SESSION["Ronda"]["Numero"] - 1), $_SESSION["Ronda"]["Numero"]);
    }
?>
    <!DOCTYPE html>
    <html lang="ca">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Votació popular Concurs Internacional de Gossos d'Atura 2023</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div>
            <h2>Accés administradors</h2>
            <form action="process_login_admin.php" method="POST">
                <input type="text" name="Usuari" placeholder="Usuari">
                <input type="password" name="Contrassenya" placeholder="Contrassenya">
                <input type="submit" value="Entra">
            </form>
            <br>
            <div class="wrapper">
                <header>Votació popular del Concurs Internacional de Gossos d'Atura 2023- FASE <span> <?php echo $_SESSION["Ronda"]["Numero"] ?> </span></header>
                <p class="info"> Podeu votar fins el dia <?php echo date("d-m-Y", strtotime($_SESSION["Ronda"]["DataFi"])) ?></p>

                <p class="warning"> <?php if (isset($_SESSION["puntsRonda" . $_SESSION["Ronda"]["Numero"]])) echo $_SESSION["missatge"] ?></p>
                <div class="poll-area">
                    <?php
                    $Gossos = getGossos("Ronda", $_SESSION["Ronda"]["Numero"]);
                    
                    if (count($Gossos) == 1) {
                    ?>
                        <form action="Punts.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $Gossos[0]["id"] ?>">
                            <label for="<?php echo $Gossos[0]["id"] ?>" class="<?php echo $Gossos[0]["id"] ?>">
                                <span class="text" style="color: red;">Guanyador!</span>
                                <div class="row">
                                    <div class="column">
                                        <div class="right">
                                            <span class="text"><?php echo $Gossos[0]["nom"] ?></span>
                                        </div>
                                        <img class="dog" alt="Musclo" src="img/<?php echo $Gossos[0]["imatge"] ?>">
                                    </div>
                                </div>
                            </label>
                        </form>
                        <?php
                    } elseif (count($Gossos) > 1) {
                        foreach ($Gossos as $Gos) {
                        ?>
                            <form action="Punts.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $Gos["id"] ?>">
                                <label for="<?php echo $Gos["id"] ?>" class="<?php echo $Gos["id"] ?>">
                                    <div class="row">
                                        <div class="column">
                                            <div class="right">
                                                <span class="text"><?php echo $Gos["nom"] ?></span>
                                            </div>
                                            <img class="dog" alt="Musclo" src="img/<?php echo $Gos["imatge"] ?>">
                                        </div>
                                    </div>
                                    <input type="submit" value="Votar">
                                </label>
                            </form>
                    <?php
                        }
                    }
                    ?>
                </div>

                <p> Mostra els <a href="resultats.php">resultats</a> de les fases anteriors.</p>
            </div>
        </div>

    </body>

    </html>
<?php
}
?>