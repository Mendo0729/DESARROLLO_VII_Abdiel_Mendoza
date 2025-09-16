<?php

require_once 'Empleado.php';
require_once 'Evaluable.php';

class Desarrollador extends Empleado implements Evaluable {

    private $lenguaje;
    private $nivel_exp;

    public function __construct($nombre, $id_empleado, $sal_base, $lenguaje, $nivel_exp) {
        parent::__construct($nombre, $id_empleado, $sal_base);
        $this->lenguaje = $lenguaje;
        $this->nivel_exp = $nivel_exp;
    }

    public function getLenguaje() {
        return $this->lenguaje;
    }

    public function setLenguaje($lenguaje) {
        $this->lenguaje = $lenguaje;
    }

    public function getExp() {
        return $this->nivel_exp;
    }

    public function setExp($nivel_exp) {
        $this->nivel_exp = $nivel_exp;
    }

    public function evaluarDesempenio() {
        switch (strtolower($this->nivel_exp)) {
            case "junior":
                return "En desarrollo";
            case "semi-senior":
                return "Sólido";
            case "senior":
                return "Experto";
            default:
                return "Nivel desconocido";
        }
    }



}
?>