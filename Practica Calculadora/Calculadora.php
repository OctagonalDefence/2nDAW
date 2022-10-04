<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html;" charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="Calculadora.css" />
</head>

<?php


//inicialitzem tot el necessari: la pantalla, les accions i operacions, la funcionalitat de les tecles...

$digitExisteix = isset($_REQUEST['digit']);
$pantallaExisteix = isset($_REQUEST['pantalla']);
$accioExisteix = isset($_REQUEST[ 'accio']);
$posicioAExisteix = isset($_REQUEST['posicioA']);
$posicioExisteix = isset($_REQUEST['posicio']);
$premerIgualExisteix = isset($_REQUEST['igual']);
$Igualpremer = "0";

if ($premerIgualExisteix && $digitExisteix && $_REQUEST['igual'] == "1" || $pantallaExisteix && str_contains($_REQUEST['pantalla'], "ERROR") || $pantallaExisteix && str_contains($_REQUEST['pantalla'], "INF")) {

    $_REQUEST['pantalla'] = "";
}

if ($pantallaExisteix) {
    $posicio = 0;
    $resultat = $_REQUEST['pantalla'];   
    $cursorMogut = mb_strpos($resultat, '|') != mb_strlen($resultat) - 1;

    if ($digitExisteix) {
        $resultat = funcionalitat($_REQUEST['digit'], $cursorMogut, $resultat, "/^e|\)$/");
        
    }
    
    
    if ( $accioExisteix) {
         $accio = $_REQUEST[ 'accio'];

        switch ( $accio) {
            case 'C':
                $resultat = "";
                $posicio = 0;
                break;
            case '=':
                $Igualpremer = "1";
                $resultat = calcul($resultat);
                break;
            case 'SIN':
            case 'COS':
            case 'TAN':
                $resultat = funcionalitatSinCosTan($resultat,  $accio, $cursorMogut);
                break;
            case '(':
                $resultat = funcionalitat( $accio, $cursorMogut, $resultat, '/^[0-9]$/');
                break;
            case '-':
                $resultat =  funcionalitatDosNegatius( $accio, $cursorMogut, $resultat);
                break;
            case 'x²':
                $resultat = Apagar($resultat, "2");
                break;
            case '⌫':
                $resultat = borrarCaracter($resultat, $cursorMogut, $posicio);
                break;
            default:
                $resultat .=  $accio;
                break;
        }
    }

    if ($posicioExisteix) {
        $resultat = preg_replace('!\|!', '', $resultat); 
        $posicio = $_REQUEST['posicio'];
        
        if (!($posicioAExisteix)) {
                
            $posicio = mb_strlen($resultat);

        } 
        
        else {

            $posicioA = $_REQUEST['posicioA'];

            if ($posicioA == '<') {

                if ($posicio > 0) {
                    $posicio = $posicio - 1;
                }
            } 
            
            else if ($posicioA == '>') {

                if ($posicio < mb_strlen($resultat)) {
                    $posicio = $posicio + 1;
                }
            }
        }

        $array = mb_str_split($resultat);
        array_splice($array, $posicio, 0, "|");
        $resultat = implode($array);

    }

} 

else {
    $posicio = 0;
    $resultat = "";
}

//funcio per a fer els calculs varis
function calcul($resultat) {
    $resultat = TancarParentesis($resultat);

    try {

        $numero = '(\d+(.\d+)?|)'; 
        $funcions = '(?:sinh?|cosh?|tanh?|abs|acosh?|asinh?|atanh?|exp|log10|deg2rad|rad2deg|sqrt|ceil|floor|round)'; 
        $operadors = '[+\/*\^%-]'; 
        $regexp = '/((' . $numero . '|' . $funcions . '\s*\((?1)+\)|\((?1)+\))(?:' . $operadors . '(?2))*)+/'; 


        if (preg_match($regexp, $resultat)) {
            $resultat = preg_replace('!\|!', '', $resultat); 


            eval('$resultat = ' . $resultat . ';');

            if (is_float($resultat)) {

                $resultat = numero_format((float)$resultat, 4, '.', '');
            }
        } 
        
        else {
            $resultat = "ERROR";
        }
    } 
    
    catch (DivisionByZeroError $e) {
        $resultat = "INF";
    } 
    
    catch (Throwable $t) {
        $resultat = "ERROR";
    }

    return $resultat;
}

//funcio per a mostrar coses en pantalla
function Cursor($string, $posar): string {
    $array = str_split($string);
    array_splice($array, strpos($string, '|'), 0, $posar);
    $string = implode($array);

    return $string;
}


function Apagar(string $resultat, string $toPow): string {
    $resultat = TancarParentesis($resultat);
    $resultat = "($resultat)**$toPow";

    return $resultat;
}

//funcio per a tancar els perentesis en cas de que se'n obri un
function TancarParentesis(string $resultat): string {
    $openBracketsCount = substr_count($resultat, '(');
    $closedBracketsCount = substr_count($resultat, ')');
    $diff = $openBracketsCount - $closedBracketsCount;

    if ($diff < 0) {

        return $resultat;
    }

    return $resultat . str_repeat(")", $diff);
}

function HEncapsular(string $resultat): bool {
    $resultat = preg_replace('!\|!', '', $resultat);
    $lastChar = substr($resultat, -1);

    return is_numeric($lastChar) || $lastChar == ')';
}

//funcio per a mostrar el resultat
function acaba(string $resultat, string $regExp): bool {
    $resultat = preg_replace('!\|!', '', $resultat); 

    if (mb_strlen($resultat) == 0) {
        return false;
    }

    return preg_match($regExp, mb_substr($resultat, -1));
}

//intent de que em funcionin el sin, cos i tan 
function funcionalitatSinCosTan($resultat,  $accio, $cursorMogut) {
    if ($cursorMogut) {

         $accio == "SIN" ? $resultat = Cursor($resultat, "sin(") : ( $accio == 'COS' ? $resultat = Cursor($resultat, "cos(") : $resultat = Cursor($resultat, "tan("));
    } 
    
    else {
        if (HEncapsular($resultat)) {
             $accio == "SIN" ? $resultat = "sin(" . $resultat . ")" : ( $accio == "COS" ? $resultat =  "cos(" . $resultat . ")" : $resultat = "tan(" . $resultat . ")");
        } 
        
        else {

             $accio == "SIN" ? $resultat .= "sin(" : ( $accio == "COS" ? $resultat .= "cos(" : $resultat .= "tan(");
        }
    }

    return $resultat;
}

//funcio per a declarar l'ordre de les operacions
function funcionalitat( $accio, $cursorMogut, $resultat, $regexp) {
    if ($cursorMogut) {

        $resultat = Cursor($resultat,  $accio);
    } 
    
    else {
        if (acaba($resultat, $regexp)) {
            $resultat .= "*";
        }

        $resultat .=  $accio;
    }

    return $resultat;
}

//funcio per a calcular 
function funcionalitatDosNegatius( $accio, $cursorMogut, $resultat) {
    if ($cursorMogut) {

        $resultat = Cursor($resultat,  $accio);
    } 
    
    else {
        if (acaba($resultat, '/^\-$/')) {
            $resultat .= "(";
        }

        $resultat .= "-";
    }

    return $resultat;
}

//funcio per a borrar un caracter
function borrarCaracter($resultat, $cursorMogut) {
    if (mb_strlen($resultat) == 1) {
        return $resultat;
    }
    
    if ($cursorMogut) {

        $resultat = borrarCursor ($resultat);
    } 
    
    else {
        $resultat = preg_replace('!\|!', '', $resultat); 
        $resultat = mb_substr($resultat, 0, -1);
    }

    return $resultat;
}
//funcio per a moure el cursor enrere quan es borri un caracter
function borrarCursor ($resultat) {
    $cursorPos = mb_strpos($resultat, '|');
    if ($cursorPos > 0) {
        $resultat = mb_substr_replace($resultat, '', $cursorPos - 1, 1);
    }

    return $resultat;
}


function mb_substr_replace($string, $canviar, $iniciar, $llargada = 1)
{
    $iniciarString = mb_substr($string, 0, $iniciar, "UTF-8");
    $acabarString = mb_substr($string, $iniciar + $llargada, mb_strlen($string), "UTF-8");

    $out = $iniciarString . $canviar . $acabarString;

    return $out;
}

?>



<body>
    <div class="container">
        <form action="" name="calc" class="calculator" method="GET">
            <input type="hidden" name="igual" value="<?= $Igualpremer ?>">
            <input type="hidden" name="posicio" value="<?= $posicio ?>">
            <input type="text" class="value" readonly name="pantalla" value="<?= $resultat ?>" />
            <span class="num posicioA"><input type="submit" name="posicioA" value="<"></span>
            <span class="num posicioA"><input type="submit" name="posicioA" value=">"></span>
            <span class="num space"><input type="submit" name= "accio" value=""></span>
            <span class="num"><input type="submit" name= "accio" value="⌫"></span>            
            <span class="num"><input type="submit" name= "accio" value="x²"></span>
            <span class="num"><input type="submit" name= "accio" value="TAN"></span>
            <span class="num"><input type="submit" name= "accio" value="SIN"></span>
            <span class="num"><input type="submit" name= "accio" value="COS"></span>
            <span class="num"><input type="submit" name= "accio" value="("></span>
            <span class="num"><input type="submit" name= "accio" value=")"></span>       
            <span class="num clear"><input type="submit" name= "accio" value="C"></span>                      
            <span class="num"><input type="submit" name="digit" value="8"></span>
            <span class="num"><input type="submit" name="digit" value="9"></span>           
            <span class="num"><input type="submit" name= "accio" value="/"></span>
            <span class="num"><input type="submit" name= "accio" value="*"></span>
            <span class="num"><input type="submit" name="digit" value="5"></span>           
            <span class="num"><input type="submit" name="digit" value="6"></span>              
            <span class="num"><input type="submit" name="digit" value="7"></span>
            <span class="num"><input type="submit" name= "accio" value="-"></span>      
            <span class="num"><input type="submit" name="digit" value="2"></span>
            <span class="num"><input type="submit" name="digit" value="3"></span>           
            <span class="num"><input type="submit" name="digit" value="4"></span>
            <span class="num plus"><input type="submit" name= "accio" value="+"></span>
            <span class="num"><input type="submit" name="digit" value="00"></span>
            <span class="num"><input type="submit" name="digit" value="0"></span>           
            <span class="num"><input type="submit" name="digit" value="1"></span>                        
            <span class="num"><input type="submit" name= "accio" value="."></span>
            <span class="num Igual"><input type="submit" name= "accio" value="="></span>
        </form>
    </div>
</body>