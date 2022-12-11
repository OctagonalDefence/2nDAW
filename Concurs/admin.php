<?php
session_start();
require_once "bd_utils.php";

//En cas d'un error en fer el login, es tornara al index.php
if (!isset($_SESSION["Usuari"])) {
    header("Location: index.php");
} 

else {    
    
    //Creem una Ronda en cas de que no n'hi hagi cap
    if (getRonda(1) == null) {
        $datesInici = ["2023-01-01", "2023-02-01", "2023-03-01", 
        "2023-04-01", "2023-05-01", "2023-06-01", "2023-07-01", "2023-08-01"];
        $datesFi = ["2023-01-31", "2023-02-28", "2023-03-31", "2023-04-30",
         "2023-05-31", "2023-06-3", "2023-07-31", "2023-08-31"];
        for ($i=0; $i < 8; $i++) { 
            $Ronda = new Ronda($i + 1, $datesInici[$i], $datesFi[$i]);
            $Ronda->insert();
        }
    }
?>
    <!DOCTYPE html>
    <html lang="ca">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ADMIN - Concurs Internacional de Gossos d'Atura</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <div class="wrapper medium">
            <header>ADMINISTRADOR - Concurs Internacional de Gossos d'Atura</header>
            <div class="admin">
                <div class="admin-row">
                    <h1> Resultat parcial: Fase <?php echo $_SESSION["Ronda"]["Numero"] ?> </h1>
                    <div class="gossos">
                        <?php
                       
                       //Els gossos que no passen de ronda, apareixeran en blanc i negre

                        $Gossos = getGossos("Ronda", $_SESSION["Ronda"]["Numero"]);
                        $newGossos = getGossosNovaRonda($_SESSION["Ronda"]["Numero"]);

                        foreach ($Gossos as $Gos) {

                            $trobat = false;
                            foreach ($newGossos as $newGos) {

                                if ($Gossos["Nom"] == $newGos["Nom"]) {

                        ?>
                                    <img class="dog" alt="<?php echo $Gossos["Nom"] ?>" title="<?php echo $Gossos["Nom"] . 
                                    " " . $Gossos["Punts"] ?>" src="img/<?php echo $Gossos["Imatge"] ?>">
                            <?php
                                    $trobat = true;
                                }
                            }
                            if (!$trobat) {
                        ?>
                        <img class="dog eliminat" alt="<?php echo $Gossos["Nom"] ?>" title="<?php echo $Gossos["Nom"] . 
                                    " " . $Gossos["Punts"] ?>" src="img/<?php echo $Gossos["Imatge"] ?>">
                        <?php
                            }
                            ?>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="admin-row">
                    <h1> Nou usuari: </h1>
                    <form action="crearUsuari.php" method="POST">
                        <input type="text" name="Usuari" placeholder="Nom">
                        <input type="password" name="Contrassenya" placeholder="Contrassenya">
                        <input type="submit" value="Crea Usuari">
                    </form>
                </div>
                <div class="admin-row">
                    <h1> Rondas: </h1>
                    <form class="Ronda-row" action="process_Ronda.php" method="POST">
                        Ronda <input type="number" name="Numero" value="1" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (getRonda(1) != null) echo getRonda(1)["DataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (getRonda(1) != null) echo getRonda(1)["DataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="Ronda-row" action="process_Ronda.php" method="POST">
                        Ronda <input type="number" name="Numero" value="2" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (getRonda(2) != null) echo getRonda(2)["DataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (getRonda(2) != null) echo getRonda(2)["DataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="Ronda-row" action="process_Ronda.php" method="POST">
                        Ronda <input type="number" name="Numero" value="3" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (getRonda(3) != null) echo getRonda(3)["DataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (getRonda(3) != null) echo getRonda(3)["DataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="Ronda-row" action="process_Ronda.php" method="POST">
                        Ronda <input type="number" name="Numero" value="4" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (getRonda(4) != null) echo getRonda(4)["DataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (getRonda(4) != null) echo getRonda(4)["DataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="Ronda-row" action="process_Ronda.php" method="POST">
                        Ronda <input type="number" name="Numero" value="5" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (getRonda(5) != null) echo getRonda(5)["DataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (getRonda(5) != null) echo getRonda(5)["DataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="Ronda-row" action="process_Ronda.php" method="POST">
                        Ronda <input type="number" name="Numero" value="6" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (getRonda(6) != null) echo getRonda(6)["DataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (getRonda(6) != null) echo getRonda(6)["DataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="Ronda-row" action="process_Ronda.php" method="POST">
                        Ronda <input type="number" name="Numero" value="7" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (getRonda(7) != null) echo getRonda(7)["DataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (getRonda(7) != null) echo getRonda(7)["DataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                    <form class="Ronda-row" action="process_Ronda.php" method="POST">
                        Ronda <input type="number" name="Numero" value="8" style="width: 3em">
                        del <input type="date" name="dataInici" value="<?php if (getRonda(8) != null) echo getRonda(8)["DataInici"] ?>" placeholder="Inici">
                        al <input type="date" name="dataFi" value="<?php if (getRonda(8) != null) echo getRonda(8)["DataFi"] ?>" placeholder="Fi">
                        <input type="submit" value="Modifica">
                    </form>

                </div>

                <div class="admin-row">
                    <h1> Concursants: </h1>

                    <?php
                    
                    
                    //Aqui es mostren tots els goossos que participen
                    
                    $Gossos = getGossos("Ronda", 1);
                    for ($i = 0; $i < count($Gossos); $i++) {
                    ?>
                        <form action="modificarGos.php" method="POST">
                            <input type="hidden" name="Nom_amagat" value="<?php echo $Gossos[$i]["Nom"] ?>">
                            <input type="text" placeholder="Nom" name="Nom" value="<?php echo $Gossos[$i]["Nom"] ?>">
                            <input type="text" placeholder="Imatge" name="Imatge" value="<?php echo $Gossos[$i]["Imatge"] ?>">
                            <input type="text" placeholder="Amo" name="Amo" value="<?php echo $Gossos[$i]["Amo"] ?>">
                            <input type="text" placeholder="Raca" name="Raca" value="<?php echo $Gossos[$i]["Raca"] ?>">
                            <input type="submit" value="Modifica">
                        </form>
                    <?php
                    }
                    ?>

                    <form action="crearGos.php" method="POST">
                        <input type="text" name="Nom" placeholder="Nom">
                        <input type="text" name="Imatge" placeholder="Imatge">
                        <input type="text" name="Amo" placeholder="Amo">
                        <input type="text" name="Raca" placeholder="Raca">
                        <input type="submit" value="Afegeix">
                    </form>
                </div>

                <div class="admin-row">
                    <h1> Altres operacions: </h1>
                    <form action="borrarPunts.php" method="POST">
                        Esborra els vots de la Ronda
                        <input type="number" name="Numero" placeholder="Ronda" value="">
                        <input type="submit" value="Esborra">
                    </form>
                    <form action="borrarPunts.php" method="POST">
                        Esborra tots els vots
                        <input type="submit" value="Esborra">
                    </form>
                </div>
            </div>
        </div>

    </body>

    </html>
<?php
}
?>