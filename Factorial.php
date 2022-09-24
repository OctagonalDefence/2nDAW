<?php


function factorialArray($farray) {
    
    $facArray = array();

    //creem un array buit per al factorial, 
    foreach($farray as $number) {  
        
        //agafem cada valor del array i, en cas de que sigui un enter positiu, el passem per la funcio ferFactorial();
        if ( is_int( $number ) && $number>= 0) {
            $facArray[] = ferFactorial($number);
        }
        
        //si no compleix la condicio, retorna fals
        else  {
            
            return false;
        }
    }   

    return $facArray;   
}

//aquesta funcio fa el factorial de cada valor de l'array
function ferFactorial($number) {
    for ($i = $number - 1; $i > 1; $i--) {
        
        $number = $i * $number;
    }

    return $number;
    }

    //crida de funcions
$arr = array(1, 2, 3, 4);
$factorial =  factorialArray($arr);
var_dump($factorial);


?>