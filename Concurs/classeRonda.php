<?php
    require_once "bd_utils.php";

    class Ronda {
        public int $Numero;
        public string $DataInici;
        public string $DataFi;

        function __construct(int $Numero, string $DataInici, string $DataFi) {

            $this->Numero = $Numero;
            $this->DataInici = date("Y-m-d", strtotime($DataInici));
            $this->DataFi =  date("Y-m-d", strtotime($DataFi));
        }

        function insert() {

            insert(RONDA, [$this->Numero, $this->DataInici, $this->DataFi]);
        }

        function updateRonda():void {
            
            update(RONDA, "DataInici", $this->DataInici, "Numero", $this->Numero);
            update(RONDA, "DataFi", $this->DataFi, "Numero", $this->Numero);
        }
    }
?>