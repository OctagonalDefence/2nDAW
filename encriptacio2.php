<?php

$string= "Hola";
echo $string;

$cifrat = "AES-128-CTR";
$l = openssl_cipher_iv_length($cifrat);
$iv = '1234567891011121';
$clau = "W3docs";
$encriptat = openssl_encrypt($string, $cifrat, $clau, $iv);

echo $encriptat;

$div = '1234567891011121';
$dclau = "W3docs";
$desencriptat = openssl_decrypt($encriptat, $cifrat, $dclau, $div);

echo $desencriptat;

?>