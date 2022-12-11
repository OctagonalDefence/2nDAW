<?php
require_once "bd_utils.php";

class Usuaris {
    public string $Usuari;
    public string $Contrassenya;

    function __construct(string $Usuari, string $Contrassenya){
        $this->Usuari = $Usuari;
        $this->Contrassenya = $Contrassenya;
    }

    function insert(){
        insert(USUARIS, [$this->Usuari, md5($this->Contrassenya)]);
    }
}
?>