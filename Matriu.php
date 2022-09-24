<?php

//creem la matriu a partir de un enter introduit

function crearMatriu($num) {

    $arr = array();
    
    //creem les files i columnes
    for ($fila = 0; $fila < $num; $fila++) {

        for ($columna = 0; $columna < $num; $columna++) {

            //si una fila es igual a una columna hi posem un * ja que vol dir que es la diagonal

            if ($columna == $fila) {

                $arr[$fila][$columna] = "*";
            } 

            //emplenem la meitat inferior de la matriu amb numeros aleatoris
            else if ($columna < $fila) {

                $arr[$fila][$columna] = rand(10, 20);
            } 

            //emplenem la resta amb la seguent operacio
            else {
                $arr[$fila][$columna] = $fila + $columna;
            }
        }
    }

    return $arr;
}

//aqui mostrem la matriu en la pantalla com si fos html

function mostrarMatriu($mat) {
    //creem la taula
    $html = "<table>";

    foreach ($mat as $clau => $valor) {
        //creem les files
        $html .= "<tr>";

        foreach ($valor as $clau2 => $valor) {
            //emplenem les files amb els valors
            $html .= "<td>" . $valor . "</td>";
        }
        //tanquem la fila actual i passa a la seguent
        $html .= "</tr>";
    }
    
    //un cop acabat amb les files, tenca la taula i la mostra
    $html .= "</table>";
    return $html;
}

//transposem la matriu mostrada en la funcio anterior i la mostrem també 

function transposarMatriu($mat) {

    //al principi creem un array buit per a la transposició i contem el numero de files de l'anterior
    $arrTransposat = array();
    $numFiles = count($mat);

    //passem per cada fila i columna
    for ($fila = 0; $fila < $numFiles; $fila++) {

        //contem el numero de columnes
        $numColumnes = count($mat[$fila]);

        //amb la seguent operació, procedim a la trensposició
        for ($columna = 0; $columna < $numColumnes; $columna++) {

            $arrTransposat[$columna][$fila] = $mat[$fila][$columna];
        }
    }

    return $arrTransposat;
}


//crida de funcions i creacio d'un array
$mat = crearMatriu(4);
echo mostrarMatriu($mat);
echo "<br><br>";
echo mostrarMatriu(transposarMatriu($mat));
echo "<br><br>";
