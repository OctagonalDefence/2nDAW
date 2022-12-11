<?php
require_once "bd_utils.php";

class Gos{
    public string $ID;
    public string $Nom;
    public string $Imatge;
    public string $Amo;
    public string $Raca;
    public string $Ronda;
    public int $Punts;

    function __construct(string $Nom, string $Imatge, string $Amo, string $Raca, string $Ronda, int $Punts = 0) {

        $this->ID = $Ronda . $Nom;
        $this->Nom = $Nom;
        $this->Imatge = $Imatge;
        $this->Amo = $Amo;
        $this->Raca = $Raca;
        $this->Ronda = $Ronda;
        $this->Punts = $Punts;
    }

    function insert() {

        insert(GOS, [$this->ID, $this->Nom, $this->Imatge, $this->Amo, $this->Raca, $this->Ronda, $this->Punts]);
    }

    function updateGos(string|int $IDVella) {

        update(GOS, "ID", $this->ID, "ID", $IDVella);
        update(GOS, "Nom", $this->Nom, "ID", $IDVella);
        update(GOS, "Imatge", $this->Imatge, "ID", $IDVella);
        update(GOS, "Amo", $this->Amo, "ID", $IDVella);
        update(GOS, "Raca", $this->Raca, "ID", $IDVella);
    }

    function afegirPunt(): void {

        update(GOS, "Punts", $this->Punts + 1, "ID", $this->ID);
    }

    function treurePunt(): void {
        
        update(GOS, "Punts", $this->Punts - 1, "ID", $this->ID);
    }
}
