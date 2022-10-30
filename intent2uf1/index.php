<?php
session_start();
//el seguent codi tanca la sessio si han passat mes de 60 segons sense autentificar-se
if(isset($_SESSION["data"])) {

    if(time() - $_SESSION["data"] < 60) {

        header("Location:hola.php", true, 302);
    } 
    
    else {

        session_destroy();
    }
}
?>


<!DOCTYPE html>
<html lang="ca">
<head>
    <title>Accés</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">

</head>
<body>                  
    <div class="Error" 
    <?php 
    //en cas de no rebre error, no es mostra 
    if(!isset($_GET["error"])) {

        echo "style='display: none;'";
    } 
    
    else {
        //en cas de rebre l'error de creacio d'usuari, mostra l'error
        if($_GET["error"] == "usuari-existeix") {

            echo "style='color:black; display:flex;  background-color:white;'";
        }
    }
    ?>>

    <?php
    //en cas de rebre altres errors, ho mostrara
    if(isset($_GET["error"])) {

        echo $_GET["error"];
    } ?>
    </div>
<br>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="process.php" method="post">
                <h1>Registra't</h1>
                <span>crea un compte d'usuari</span>
                <input type="hidden" name="method" value="signup"/>
                <input type="text" name="Nom"  placeholder="Nom" />
                <input type="email" name="Correu"  placeholder="Correu electronic" />
                <input type="password" name="Contrassenya" placeholder="Contrasenya" />
                <button>Registra't</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="process.php" method="post">
                <h1>Inicia la sessió</h1>
                <span>introdueix les teves credencials</span>
                <input type="hidden" name="method" value="signin"/>
                <input type="email" name="Correu" placeholder="Correu electronic" />
                <input type="password" name="Contrassenya" placeholder="Contrasenya" />
                <button>Inicia la sessió</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Ja tens un compte?</h1>
                    <p>Introdueix les teves dades per connectar-nos de nou</p>
                    <button class="ghost" id="signIn">Inicia la sessió</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Primera vegada per aquí?</h1>
                    <p>Introdueix les teves dades i crea un nou compte d'usuari</p>
                    <button class="ghost" id="signUp">Registra't</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
</script>
</html>