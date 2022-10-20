
<?php

session_start();
$Errors = "hidden";

if (isset($_GET['data'])) { 
   $_SESSION['data'] = $_GET['data'];
}

//comença la sessio, amagant els errors i agafant la data amb el GET

if (!isset($_SESSION['data']) || $_SESSION['data'] != date("Ymd")) { 

    if (!isset($_SESSION['data'])) { 

        $_SESSION['data'] = date("Ymd");
    }

    crearLletres();
    $_SESSION['correctes'] = array();
}

//aqui comprova que si la data te valor, en cas de que no en tingui, es generen les lletres


if (isset($_GET['error'])) { 
    $Errors = "shown";
}
//en cas de que dongui error, el mostra


var_dump($_SESSION['Funcions']);

function crearLletres() {
    $minFuncions = null;
    srand($_SESSION['data']);
    $llistatFuncions = get_defined_functions()['internal'];

    while ($minFuncions == null) {

        $alf = str_split("abcdefghijklmnopqrstuvwxyz_", 1);
        shuffle($alf);
        $_SESSION['lletraimportant'] = $alf[0];
        $_SESSION['lletra'] = array($alf[1], $alf[2], $alf[3], $alf[4], $alf[5], $alf[6]);
        $minFuncions = comprovarFuncions(3, $llistatFuncions);
    }
}
//aquesta funcio crea les lletra dels hexagons, incluida la "lletraimportant", que es la del mig

function comprovarFuncions(int $quantitat, array $llistatFuncions) {

    $l0 = $_SESSION['lletraimportant'];
    $l1 = $_SESSION['lletra'][0];
    $l2 = $_SESSION['lletra'][1];
    $l3 = $_SESSION['lletra'][2];
    $l4 = $_SESSION['lletra'][3];
    $l5 = $_SESSION['lletra'][4];
    $l6 = $_SESSION['lletra'][5];
    $regex = "/^[$l0$l1$l2$l3$l4$l5$l6]+$/";
    $_SESSION['Funcions'] = array();

    foreach ($llistatFuncions as $funcio) {

        if (str_contains($funcio, $l0) && preg_match($regex, $funcio)) {

            $_SESSION['Funcions'][] = $funcio;
        }
    }
    if (count($_SESSION['Funcions']) >= $quantitat) {

        return $_SESSION['Funcions'];
    }

    return null;
}
?>
<!DOCTYPE html>
<html lang="ca">

<head>
    <title>PHPògic</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Juga al PHPògic.">
    <link href="//fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="cssWordGame.css" rel="stylesheet">
</head>

<body data-joc="2022-10-07">
    <div class="main">
        <h1>
            <a href=""><img src="logo.png" height="54" class="logo" alt="PHPlògic"></a>
        </h1>


        <div class="container-notifications">
            <p class="hide" id="message" style='visibility: <?= $Errors ?>;'><?= $_GET['error'] ?></p>
        </div>
        <form method="POST" class="main" action="WordGuess2.php">
            <!-- Començem el post, molt important linkejar el php de verificacio -->
            <div class="cursor-container">
                <p id="input-word"><span id="test-word"></span><span id="cursor">|</span></p>
                <input type="text" hidden="true" id="test-word-input" name="paraula">
            </div>

            <div class="container-hexgrid">
                <ul id="hex-grid">
                    <?php
                    for ($i = 0; $i < count($_SESSION['lletra']); $i++) {
                        echo '<li class="hex"><div class="hex-in"><a class="hex-link" datalletra=' . $_SESSION['lletra'][$i] . ' draggable="false"><p class="valor">' . $_SESSION['lletra'][$i] . '</p></a></div></li>';
                        if ($i == 2) {

                            echo '<li class="hex"><div class="hex-in"><a class="hex-link" datalletra=' . $_SESSION['lletraimportant'] . ' draggable="false" id="center-letter"><p class="valor">' . $_SESSION['lletraimportant'] . '</p></a></div> </li>';
                        }
                    }
                    //fem la crida al valor de les lletres dels hexagons
                    ?>
                </ul>
            </div>

            <div class="button-container">
                <button id="delete-button" type="button" title="Suprimeix l'última lletra" onclick="suprimeix()"> Suprimeix</button>
                <button id="shuffle-button" type="button" class="icon" aria-label="Barreja les lletres" title="Barreja les lletres">
                    <svg width="16" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M370.72 133.28C339.458 104.008 298.888 87.962 255.848 88c-77.458.068-144.328 53.178-162.791 126.85-1.344 5.363-6.122 9.15-11.651 9.15H24.103c-7.498 0-13.194-6.807-11.807-14.176C33.933 94.924 134.813 8 256 8c66.448 0 126.791 26.136 171.315 68.685L463.03 40.97C478.149 25.851 504 36.559 504 57.941V192c0 13.255-10.745 24-24 24H345.941c-21.382 0-32.09-25.851-16.971-40.971l41.75-41.749zM32 296h134.059c21.382 0 32.09 25.851 16.971 40.971l-41.75 41.75c31.262 29.273 71.835 45.319 114.876 45.28 77.418-.07 144.315-53.144 162.787-126.849 1.344-5.363 6.122-9.15 11.651-9.15h57.304c7.498 0 13.194 6.807 11.807 14.176C478.067 417.076 377.187 504 256 504c-66.448 0-126.791-26.136-171.315-68.685L48.97 471.03C33.851 486.149 8 475.441 8 454.059V320c0-13.255 10.745-24 24-24z"></path>
                    </svg>
                </button>
                <button id="submit-button" type="submit" title="Introdueix la paraula">Introdueix</button>
            </div>
        </form>

        <div class="scoreboard">
            <div>
                Has trobat <span id="letters-found"><?= count($_SESSION['correctes']) ?>
                </span> <span id="found-suffix">funcions</span><span id="discovered-text">: <?= implode(", ", $_SESSION['correctes']) ?></span>
            </div>
            <div id="score"></div>
            <div id="level"></div>
        </div>
    </div>
    <script>
        function amagaError() {
            if (document.getElementById("message"))
                document.getElementById("message").style.opacity = "0"
        }

        function afegeixLletra(lletra) {
            document.getElementById("test-word").innerHTML += lletra;
            document.getElementById("test-word-input").value = document.getElementById("test-word").innerHTML;
        }

        function suprimeix() {
            document.getElementById("test-word").innerHTML = document.getElementById("test-word").innerHTML.slice(0, -1);
            document.getElementById("test-word-input").value = document.getElementById("test-word").innerHTML;
        }

        window.onload = () => {
            // Afegeix funcionalitat al click de les lletres
            Array.from(document.getElementsByClassName("hex-link")).forEach((el) => {
                el.onclick = () => {
                    afegeixLletra(el.getAttribute("datalletra"))
                }
            })

            setTimeout(amagaError, 2000)

            //Anima el cursor
            let estat_cursor = true;
            setInterval(() => {
                document.getElementById("cursor").style.opacity = estat_cursor ? "1" : "0"
                estat_cursor = !estat_cursor
            }, 500)

            //part extra:
            document.body.addEventListener('keyup', function(event) {
                lletres = document.getElementsByClassName("valor");
                is = false;
                for (let i = 0; i < lletres.length; i++) {

                    if (event.key == lletres[i].innerHTML) {

                        is = true;
                    }
                }

                if (is) {

                    document.getElementById("test-word").innerHTML += event.key;
                    document.getElementById("test-word-input").value = document.getElementById("test-word").innerHTML;
                } else if (event.key.toString() == "Backspace") {

                    suprimeix();
                }
            });
        }
    </script>
</body>

</html>