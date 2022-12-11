<?php
session_start();

require_once "bd_utils.php";
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultat votació popular Concurs Internacional de Gossos d'Atura</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper large">
        <header>Resultat de la votació popular del Concurs Internacional de Gossos d'Atura 2023</header>
        <div class="results">
            <?php
            $Rondes = getRondes();
            foreach ($Rondes as $Ronda) {
                $Gossos = getGossos("Ronda", $Rondes["Numero"]);

                if ($Gossos != null) {
            ?>
                    <h1> Resultat fase <?php echo $Rondes["Numero"] ?></h1>
                    <?php
                }
                
                foreach ($Gossos as $Gos) {
                    
                    if (getGossos("ID", $Gossos["Ronda"] + 1 . $Gossos["Nom"]) != null || getGossos("Ronda", $Gossos["Ronda"] + 1) == null) {
                    ?>
                        <img class="dog" alt="<?php echo $Gossos["Nom"] ?>" title="<?php echo $Gossos["Nom"] ?>" src="img/<?php echo $Gossos["Imatge"] ?>">
                    <?php
                    } 
                    
                    else {
                    ?>
                        <img class="dog eliminat" alt="<?php echo $Gossos["Nom"] ?>" title="<?php echo $Gossos["Nom"] ?>" src="img/<?php echo $Gossos["Imatge"] ?>">
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            <?php
            }
            ?>
        </div>

    </div>

</body>

</html>