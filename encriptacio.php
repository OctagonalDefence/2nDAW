<?php

$sp = "kfhxivrozziuortghrvxrrkcrozxlwflrh";
$mr = " hv ovxozwozv vj o vfrfjvivfj h vmzvlo e hrxvhlmov oz ozx.vw z xve hv loqvn il hv lmnlg izxvwrhrvml ,hv b lh mv,rhhv mf w zrxvlrh.m";


function decrypt1(String $a) {
    $arr = str_split($a, 3);
    foreach($arr as $subarr){
        $subarr = strrev($subarr);
        $subarr = rotar($subarr);
        //echo "$subarr <br>";        
    }
   
}

function rotar (String $b) {
    $ch;
    for ($i = 0; $i < strlen($b); $i++)
    {
        $ch = $b[$i];
        if($ch == ' ') {
            echo ($ch);
        }  
        else if($ch == '.') {
            echo ($ch);
        }
        else if($ch == ',') {
            echo ($ch);
        }  
        else {
            $ch = chr(122 -
                      ord($ch) + 97);
            echo ($ch);
        }
            
    }
}

echo decrypt1($sp);
echo '<xmp></xmp>'
echo decrypt($mr);

 ?>
